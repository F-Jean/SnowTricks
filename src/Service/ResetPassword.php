<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ResetPassword
{
    private $manager;
    private $flashBag;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $manager, FlashBagInterface $flashBag, UserPasswordHasherInterface $passwordHasher)
    {
        $this->manager = $manager;
        $this->flashBag = $flashBag;
        $this->passwordHasher = $passwordHasher;
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