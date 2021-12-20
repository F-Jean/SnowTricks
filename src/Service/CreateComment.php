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
        $comment->setTrick($trick);
        $this->manager->persist($comment);
        $this->manager->flush();
    }
}