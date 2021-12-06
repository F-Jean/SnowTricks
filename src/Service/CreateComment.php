<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class CreateComment
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    
    public function __invoke($user, $comment, $trick) {
        $comment->setPostedAt(new \DateTimeImmutable())
                    ->setTrick($trick)
                    ->setUser($user);
            $this->manager->persist($comment);
            $this->manager->flush();
    }
}