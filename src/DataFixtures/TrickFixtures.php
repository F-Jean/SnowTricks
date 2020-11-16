<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Trick;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Illustration;

class TrickFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <=3; $i++) {
            $user = new User();
            $user->setUserName("Utilisateur : $i")
                 ->setEmail("Email : $i")
                 ->setPassword("Mot de passe : $i");

            $manager->persist($user);
        }

        for ($j = 1; $j <=2; $j++) {
            $category = new Category();
            $category->setName("catégorie : $j");

            $manager->persist($category);
        }

        for($k = 1; $k <=30; $k++){
            $illustration = new Illustration();
            $illustration->setPath("https://placehold.co/350x300");
            $trick = new Trick();
            $trick->setName("Trick N° $k")
                  ->addIllustration($illustration)
                  ->setDescription("<p>Description figure : $k</p>")
                  ->setAddedAt(new \DateTimeImmutable())
                  ->setUser($user)
                  ->setCategory($category);

            $manager->persist($illustration);
            $manager->persist($trick);
        }

        $manager->flush();
    }
}
