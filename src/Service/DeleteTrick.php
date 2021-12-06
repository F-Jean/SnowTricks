<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class DeleteTrick
{
    private $manager;
    private $flashBag;
    
    public function __construct(EntityManagerInterface $manager, FlashBagInterface $flashBag)
    {
        $this->manager = $manager;
        $this->flashBag = $flashBag;
    }

    public function deleteTrick($trick) {
        //Delete illustrations when trick is delete
        $illustrations = $trick->getIllustrations();
        if($illustrations) {
            // Loop on trick illustrations
            foreach($illustrations as $illustration) {
                $illustrationName = __DIR__.'/../../public/uploads/trick_images'.'/'.$illustration->getPath();
                // Check if illustration exist
                if(file_exists($illustrationName)) {
                    unlink($illustrationName);
                }
            }
        }
        $this->manager->remove($trick);
        $this->manager->flush();

        $this->flashBag->add('success', 'La figure a bien été supprimé !');
    }
}