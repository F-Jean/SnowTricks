<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Trick;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Illustration;
use App\Entity\Video;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class TrickFixtures extends Fixture
{
    private $userEncoder;

    public function __construct(UserPasswordEncoderInterface $userEncoder)
    {
        $this->userEncoder = $userEncoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <=3; $i++) {
            $user = new User();
            $user->setUserName("Utilisateur $i")
                ->setEmail("Email" . $i . "@email.com")
                ->setPassword($this->userEncoder->encodePassword($user, "password"));

            $manager->persist($user);
            $users[] = $user;
        }

        for ($j = 1; $j <=2; $j++) {
            $category = new Category();
            $category->setName("catégorie : $j");
            $manager->persist($category);

            foreach ($users as $user) {
                for ($k = 1; $k <=20; $k++) {
                    $trick = new Trick();
                    $trick->setName("Trick N° $k")
                    ->setDescription("<p>Description figure : $k</p>")
                    ->setAddedAt(new \DateTimeImmutable())
                    ->setUser($user)
                    ->setCategory($category);
                    $manager->persist($trick);
                

                    for ($l = 1; $l <= 5; $l++) {
                        $illustration = new Illustration();
                        $illustration->setPath("https://placehold.co/350x300");
                        $trick->addIllustration($illustration);
                        $manager->persist($illustration);
                    }

                    for ($m = 1; $m <= 5; $m++) {
                        $video = new Video();
                        $video->setUrl("https://www.youtube.com/embed/8CtWgw9xYRE");
                        $trick->addVideo($video);
                        $manager->persist($video);
                    }
                }
            }
        }
    $manager->flush();
    }
}     
