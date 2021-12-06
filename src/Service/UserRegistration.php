<?php

namespace App\Service;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\ValidationMail;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class UserRegistration
{
    private $passwordHasher;
    private $mailer;
    private $manager;
    private $flashBag;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $manager, ValidationMail $mailer, FlashBagInterface $flashBag)
    {
        $this->passwordHasher = $passwordHasher;
        $this->manager = $manager;
        $this->mailer = $mailer;
        $this->flashBag = $flashBag;
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
}