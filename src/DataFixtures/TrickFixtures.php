<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Trick;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Illustration;
use App\Entity\Video;
use App\Entity\Comment;
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
        // USERS
        for ($i = 1; $i <=3; $i++) {
            $user = new User();
            $user->setUserName("Utilisateur $i")
                ->setEmail("Email" . $i . "@email.com")
                ->setPassword($this->userEncoder->encodePassword($user, "password"));

            $manager->persist($user);
            $users[] = $user;
        }

        // CATEGORIES
        for ($j = 1; $j <=6; $j++) {
            $category = new Category();
            $category->setName("catégorie : $j");
            $manager->persist($category);
                
            // TRICKS
            for ($k = 1; $k <=20; $k++) {
                $trick = new Trick();
                $trick->setName("Trick N° $k")
                ->setDescription("<p>Description figure : $k</p>")
                ->setAddedAt(new \DateTimeImmutable())
                ->setUser($user)
                ->setCategory($category);
                $manager->persist($trick);
        
                // ILLUSTRATIONS
                for ($l = 1; $l <= 5; $l++) {
                    $illustration = new Illustration();
                    $illustration->setPath("https://placehold.co/350x300");
                    $trick->addIllustration($illustration);
                    $manager->persist($illustration);
                }

                //VIDEOS
                for ($m = 1; $m <= 5; $m++) {
                    $video = new Video();
                    // manually setting the url for the moment (copy of the user's  one will be sending)
                    $video->setUrl("https://www.youtube.com/watch?v=1TJ08caetkw");
                    $urlVideo = $video->getUrl();
                    $ytUrl = "https://www.youtube.com/embed/";
                    $dmUrl = "https://www.dailymotion.com/embed/video/";
                    if (preg_match("#youtube#", $urlVideo)) {
                        // regex to isolate a youtube url' id specifically
                        preg_match('#https:\/\/www\.youtube\.com\/watch\?v=(.+)#', $urlVideo, $matches);
                        $ytId = $matches[1];
                        // adding embed url to isolate id
                        $ytUrlVideo = $ytUrl . $ytId;
                        $video->setUrl($ytUrlVideo);
                    } elseif (preg_match("#dailymotion#", $urlVideo)) {
                        // regex to isolate a dailymotion url' id specifically
                        preg_match('#https:\/\/www\.dailymotion\.com\/video\/(.+)#', $urlVideo, $matches);
                        $dmId = $matches[1];
                        // adding embed url to isolate id
                        $dmUrlVideo = $dmUrl . $dmId;
                        $video->setUrl($dmUrlVideo);
                    }
                    $trick->addVideo($video);
                    $manager->persist($video);
                }

                foreach ($users as $user) {
                    // COMMENTS
                    for ($n = 1; $n <=3; $n++) {
                        $comment = new Comment();
                        $comment->setUser($user);
                        $comment->setTrick($trick)
                        ->setPostedAt(new \DateTimeImmutable())
                        ->setContent("Commentaire n° $n");
                        $manager->persist($comment);
                    }
                }      
            }
            $manager->flush();
        }
    }
}