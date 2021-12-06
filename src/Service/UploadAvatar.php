<?php

namespace App\Service;

use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\ORM\EntityManagerInterface;

class UploadAvatar
{
    private $slugger;
    private $manager;
    
    public function __construct(SluggerInterface $slugger, EntityManagerInterface $manager)
    {
        $this->slugger = $slugger;
        $this->manager = $manager;
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
}