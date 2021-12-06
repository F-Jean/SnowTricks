<?php

namespace App\Service;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Uid\Uuid;
use App\Service\ValidationMail;

class ForgottenPassword
{
    private $manager;
    private $flashBag;
    private $mailer;
    private $userRepository;

    public function __construct(EntityManagerInterface $manager, FlashBagInterface $flashBag, ValidationMail $mailer, UserRepository $userRepository)
    {
        $this->manager = $manager;
        $this->flashBag = $flashBag;
        $this->mailer = $mailer;
        $this->userRepository = $userRepository;
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
}