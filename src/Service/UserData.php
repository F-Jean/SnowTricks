<?php

namespace App\Service;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\ValidationMail;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Repository\UserRepository;

class UserData
{
    private $passwordHasher;
    private $mailer;
    private $manager;
    private $flashBag;
    private $slugger;
    private $userRepository;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $manager, ValidationMail $mailer, FlashBagInterface $flashBag, SluggerInterface $slugger, UserRepository $userRepository)
    {
        $this->passwordHasher = $passwordHasher;
        $this->manager = $manager;
        $this->mailer = $mailer;
        $this->flashBag = $flashBag;
        $this->slugger = $slugger;
        $this->userRepository = $userRepository;
    }
    public function userRegistration($user) {
        $user->setPassword($this->passwordHasher->hashPassword(
            $user, 
            $user->getPlainPassword()
        ));
        $user->setToken(Uuid::v4());
        $this->manager->persist($user);
        $this->manager->flush();
        $this->mailer->sendEmail($user->getEmail(), $user->getToken());
        $this->flashBag->add("success", "Inscription réussie ! Allez vérifier votre email avant la connexion.");
    }

    public function uploadAvatar($user) {
        $uploadedFile = $user->getavatarFile();
            $destination = __DIR__.'/../../public/uploads/users_avatar';

            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();

            $uploadedFile->move(
                $destination,
                $newFilename
            );

            $user->setAvatar($newFilename);

            $this->manager->persist($user);
            $this->manager->flush();
    }

    public function accountActivator($user) {
        $user->setToken(null);
        $user->setEnabled(true);
        $this->manager->persist($user);
        $this->manager->flush();
        $this->flashBag->add("success", "Votre compte est activé !");
    }

    public function checkUser($data) {
        // we're searching if a user have this email
        $user = $this->userRepository->findOneByEmail($data['email']);
        // if there is no user
        if(!$user)
        {
            $this->flashBag->add("error", "Cette adresse n'existe pas !");
            return;
        }
        // otherwise generate a token
        $resetToken = Uuid::v4();
        // checking if well written in db ('cause if failed it's useless to send the email)
        try{
            $user->setResetToken($resetToken);
            $this->manager->persist($user);
            $this->manager->flush();
            // sending the email (SERVICE ValidationMail)
            $this->mailer->sendResetEmail($user->getEmail(), $user->getResetToken());

            $this->flashBag->add("success", "Un e-mail de réinitialisation de mot de passe vous a été envoyé.");
        }catch(\Exception $e){
            $this->flashBag->add("error", "Une erreur est survenue :". $e->getMessage());
        }
    }

    public function resetToken($user, string $newPassword) {
        $user->setResetToken(null);
        $user->setPassword($this->passwordHasher->hashPassword(
            $user, 
            $newPassword
        ));
        $this->manager->persist($user);
        $this->manager->flush();

        $this->flashBag->add("success", "Le mot de passe a bien été modifié.");
    }
}