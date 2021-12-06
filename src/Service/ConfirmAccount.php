<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ConfirmAccount
{
    private $manager;
    private $flashBag;

    public function __construct(EntityManagerInterface $manager, FlashBagInterface $flashBag)
    {
        $this->manager = $manager;
        $this->flashBag = $flashBag;
    }

    public function accountActivator($user) {
        $user->setToken(null);
        $user->setEnabled(true);
        $this->manager->persist($user);
        $this->manager->flush();
        $this->flashBag->add("success", "Votre compte est activé !");
    }
}