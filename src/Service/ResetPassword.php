<?php

namespace App\Service;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ResetPassword
{
    private $manager;
    private $flashBag;
    private $userRepository;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $manager, FlashBagInterface $flashBag, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher)
    {
        $this->manager = $manager;
        $this->flashBag = $flashBag;
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function resetToken($resetToken, $form) {
        // we seach the user corresponding to the token used
        $user = $this->userRepository->findOneBy(['resetToken' => $resetToken]);
        if(!$user)
        {
            $this->flashBag->add("error", "Token inconnu !");
            return;
        }
    
        $user->setResetToken(null);
        $user->setPassword($this->passwordHasher->hashPassword(
            $user, 
            $form->get('resetPassword')->getData()
        ));
        $this->manager->persist($user);
        $this->manager->flush();

        $this->flashBag->add("success", "Le mot de passe a bien été modifié.");
    }
}