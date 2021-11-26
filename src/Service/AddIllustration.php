<?php

namespace App\Service;

use App\Entity\Trick;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class AddIllustration 
{
    protected $requestStack;

    public function __construct(SluggerInterface $slugger, EntityManagerInterface $manager, FlashBagInterface $flashBag)
    {
        $this->slugger = $slugger;
        $this->manager = $manager;
        $this->flashBag = $flashBag;
    }

    public function addIllustration(Trick $trick) 
    {
        foreach ($trick->getIllustrations() as $illustration) {
            $uploadedFile = $illustration->getFile();
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
    
        $this->manager->persist($trick);
        $this->manager->flush();

        /* add a success flash message */
        $this->flashBag->add('success', 'La figure a bien été ajouté !');
    }
}