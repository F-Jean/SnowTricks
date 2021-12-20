<?php

namespace App\Service;

use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class EditIllustration 
{
    private $slugger;
    private $manager;
    private $flashBag;

    public function __construct(SluggerInterface $slugger, EntityManagerInterface $manager, FlashBagInterface $flashBag)
    {
        $this->slugger = $slugger;
        $this->manager = $manager;
        $this->flashBag = $flashBag;
    }

    public function editIllustration($trick) {
        foreach ($trick->getIllustrations() as $illustration) {
            $uploadedFile = $illustration->getFile();
            if($uploadedFile == null) {
                continue;
            }
            $destination = __DIR__.'/../../public/uploads/trick_images';

            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();

            $uploadedFile->move(
                $destination,
                $newFilename
            );

            $illustration->setPath($newFilename);
        }

        $this->manager->flush();

        /* add a success flash message */
        $this->flashBag->add('success', 'La figure a bien été modifié !');
    }
}