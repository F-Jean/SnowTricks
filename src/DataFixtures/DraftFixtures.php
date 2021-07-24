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

class DraftFixtures extends Fixture
{
    private $userEncoder;

    public function __construct(UserPasswordEncoderInterface $userEncoder)
    {
        $this->userEncoder = $userEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // ARRAYS :
        // USERS ARRAY
        $users = array(
            "user01" => array("email" => "jean@symfony.com",
                            "username" => "fjean",
                            "password" => "Password1"
            ),
            "user02" => array("email" => "loic@orange.com",
                            "username" => "lolo",
                            "password" => "Password2"
            ),
            "user03" => array("email" => "antoine@gmail.com",
                            "username" => "tonio",
                            "password" => "Password3"
            ),
            "user04" => array("email" => "claire@symfony.com",
                            "username" => "claire",
                            "password" => "Password4"
            ),
            "user05" => array("email" => "marie@symfony.com",
                            "username" => "marie",
                            "password" => "Password5"
            ),
            "user06" => array("email" => "john@symfony.com",
                            "username" => "bigJ",
                            "password" => "Password6"
            ),
        );
        // CATEGORIES ARRAY
        $categories = array("Grabs", "Rotations", "Flips", "Rotations désaxées", "Slides", "One foot tricks", "Old school");
        
        // TRICKS ARRAY
        $tricks = array(
            // Grabs
            "trick01" => array("name" => "Nose Grab",
                            "description" => "La main avant grab le bout avant (nose) de la board. Levez votre jambe avant et étendez votre jambe arrière pour 
                            amener votre board vers votre main.</br>
                            Un grab consiste à attraper la planche avec la main pendant le saut. Le verbe anglais to grab signifie « attraper. »</br>
                            Il existe plusieurs types de grabs selon la position de la saisie et la main choisie pour l'effectuer.</br>
                            Un grab est d'autant plus réussi que la saisie est longue. De plus, le saut est d'autant plus esthétique que la saisie du snowboard 
                            est franche, ce qui permet au rideur d'accentuer la torsion de son corps grâce à la tension de sa main sur la planche. On dit alors 
                            que le grab est tweaké (le verbe anglais to tweak signifie « pincer » mais a également le sens de « peaufiner »).",
            ),
            "trick02" => array("name" => "China air",
                            "description" => "La main avant grab la partie avant du snowboard. Les deux genoux sont pliés.",
            ),
            // Rotations
            "trick03" => array("name" => "180",
                            "description" => "Un demi-tour, soit 180 degrés d'angle.</br>
                            Le principe est d'effectuer une rotation horizontale pendant le saut, puis d'attérir en position switch ou normal. La nomenclature se 
                            base sur le nombre de degrés de rotation effectués.</br>
                            Une rotation peut être frontside ou backside : une rotation frontside correspond à une rotation orientée vers la carre backside. Cela 
                            peut paraître incohérent mais l'origine étant que dans un halfpipe ou une rampe de skateboard, une rotation frontside se déclenche 
                            naturellement depuis une position frontside (i.e. l'appui se fait sur la carre frontside), et vice-versa. Ainsi pour un rider qui a 
                            une position regular (pied gauche devant), une rotation frontside se fait dans le sens inverse des aiguilles d'une montre.</br>
                            Une rotation peut être agrémentée d'un grab, ce qui rend le saut plus esthétique mais aussi plus difficile car la position tweakée a 
                            tendance à déséquilibrer le rideur et désaxer la rotation. De plus, le sens de la rotation a tendance à favoriser un sens de grab 
                            plutôt qu'un autre. Les rotations de plus de trois tours existent mais sont plus rares, d'abord parce que les modules assez gros pour 
                            lancer un tel saut sont rares, et ensuite parce que la vitesse de rotation est tellement élevée qu'un grab devient difficile, ce qui 
                            rend le saut considérablement moins esthétique.",
            ),
            "trick04" => array("name" => "360",
                            "description" => "360, ou trois six pour un tour complet.</br>
                            Le principe est d'effectuer une rotation horizontale pendant le saut, puis d'attérir en position switch ou normal. La nomenclature 
                            se base sur le nombre de degrés de rotation effectués.</br>
                            Une rotation peut être frontside ou backside : une rotation frontside correspond à une rotation orientée vers la carre backside. 
                            Cela peut paraître incohérent mais l'origine étant que dans un halfpipe ou une rampe de skateboard, une rotation frontside se déclenche 
                            naturellement depuis une position frontside (i.e. l'appui se fait sur la carre frontside), et vice-versa. Ainsi pour un rider qui a une 
                            position regular (pied gauche devant), une rotation frontside se fait dans le sens inverse des aiguilles d'une montre.</br>
                            Une rotation peut être agrémentée d'un grab, ce qui rend le saut plus esthétique mais aussi plus difficile car la position tweakée a 
                            tendance à déséquilibrer le rideur et désaxer la rotation. De plus, le sens de la rotation a tendance à favoriser un sens de grab 
                            plutôt qu'un autre. Les rotations de plus de trois tours existent mais sont plus rares, d'abord parce que les modules assez gros pour 
                            lancer un tel saut sont rares, et ensuite parce que la vitesse de rotation est tellement élevée qu'un grab devient difficile, ce qui 
                            rend le saut considérablement moins esthétique.",
            ),
            // Flips
            "trick05" => array("name" => "Back flip",
                            "description" => "Rotation verticale en arrière lors d'un saut. Il est possible de faire plusieurs flips à la suite, et d'ajouter un 
                            grab à la rotation.</br>
                            Les flips agrémentés d'une vrille existent aussi (Mac Twist, Hakon Flip...), mais de manière beaucoup plus rare, et se confondent 
                            souvent avec certaines rotations horizontales désaxées.</br> 
                            Néanmoins, en dépit de la difficulté technique relative d'une telle figure, le danger de retomber sur la tête ou la nuque est réel 
                            et conduit certaines stations de ski à interdire de telles figures dans ses snowparks.",
            ),
            // Rotations désaxées
            "trick06" => array("name" => "McTwist",
                            "description" => "Un backside 540 avant-flip, exécuté dans un half-pipe, un quarterpipe ou un obstacle similaire.",
            ),
            "trick07" => array("name" => "Misty",
                            "description" => "Le Misty Flip est une rotation arrière hors axe 540.</br>
                            Une rotation désaxée est une rotation initialement horizontale mais lancée avec un mouvement des épaules particulier qui désaxe la 
                            rotation.</br>
                            Certaines de ces rotations, bien qu'initialement horizontales, font passer la tête en bas.</br>
                            Bien que certaines de ces rotations soient plus faciles à faire sur un certain nombre de tours (ou de demi-tours) que d'autres, il est 
                            en théorie possible de d'attérir n'importe quelle rotation désaxée avec n'importe quel nombre de tours, en jouant sur la quantité de 
                            désaxage afin de se retrouver à la position verticale au moment voulu.</br>
                            Il est également possible d'agrémenter une rotation désaxée par un grab.)",
            ),
            // Slides
            "trick08" => array("name" => "Boardslide",
                            "description" => "Une glissade effectuée où le pied fort du snowboarder passe au-dessus du rail à l'approche, avec son snowboard 
                            se déplaçant perpendiculairement le long du rail ou d'un autre obstacle. Lors de l'exécution d'un boardslide frontside, le 
                            snowboarder fait face à la montée. Lors de l'exécution d'un backside boardslide, un snowboarder fait face à la descente. C'est souvent 
                            déroutant pour les nouveaux riders qui apprennent le trick car avec un boardslide frontside vous reculez et avec un boardslide backside 
                            vous avancez.",
            ),
            // One foot tricks
            "trick09" => array("name" => "One-foot Indy",
                            "description" => "Lors du saut la main arrière grab la partie arrière du snowboard ou le pied arrière a été détaché. La jambe arrière 
                            est écarté vers l'arrière du snowboard avant de revenir en place avant la fin du saut en restant toujours détaché. ",
            ),
            // Old school
            "trick10" => array("name" => "Japan air",
                            "description" => "La main avant grab la carre front au niveau de la fix avant, les genoux sont pliés, et la board est tirée vers 
                            le haut.</br>
                            Un grab consiste à attraper la planche avec la main pendant le saut. Le verbe anglais to grab signifie « attraper. »</br>
                            Il existe plusieurs types de grabs selon la position de la saisie et la main choisie pour l'effectuer.</br>
                            Un grab est d'autant plus réussi que la saisie est longue. De plus, le saut est d'autant plus esthétique que la saisie du snowboard 
                            est franche, ce qui permet au rideur d'accentuer la torsion de son corps grâce à la tension de sa main sur la planche. On dit alors 
                            que le grab est tweaké (le verbe anglais to tweak signifie « pincer » mais a également le sens de « peaufiner »).",
            )
        );

        // ILLUSTRATIONS ARRAY
        $illustrations = array(
            // GRABS
            // Nose Grab
            "illustration01" => array("path" => "/public/img/nose-grab_01.jpg",
            ),
            "illustration02" => array("path" => "/public/img/nose-grab_02.jpg",
            ),
            "illustration03" => array("path" => "/public/img/nose-grab_03.jpg",
            ),
            // China air
            "illustration04" => array("path" => "/public/img/china-air_01.jpg",
            ),
            "illustration05" => array("path" => "/public/img/china-air_02.jpg",
            ),
            // ROTATIONS
            // 180
            "illustration06" => array("path" => "/public/img/180_01.jpg",
            ),
            "illustration07" => array("path" => "/public/img/180_02.jpg",
            ),
            // 360
            "illustration08" => array("path" => "/public/img/360_01.jpg",
            ),
            "illustration09" => array("path" => "/public/img/360_02.jpg",
            ),
            // FLIPS
            // Back flip
            "illustration10" => array("path" => "/public/img/backflip_01.jpg",
            ),
            "illustration11" => array("path" => "/public/img/backflip_02.jpg",
            ),
            "illustration12" => array("path" => "/public/img/backflip_03.jpg",
            ),
            "illustration13" => array("path" => "/public/img/backflip_04.jpg",
            ),
            // ROTATIONS DESAXEES
            // McTwist
            "illustration14" => array("path" => "/public/img/McTwist_01.jpg",
            ),
            "illustration15" => array("path" => "/public/img/McTwist_02.jpg",
            ),
            // Misty
            "illustration16" => array("path" => "/public/img/misty.jpg",
            ),
            // SLIDES
            // Boardslide
            "illustration17" => array("path" => "/public/img/slide_01.jpg",
            ),
            "illustration18" => array("path" => "/public/img/slide_02.jpg",
            ),
            "illustration19" => array("path" => "/public/img/slide_03.jpg",
            ),
            // ONE FOOT TRICKS
            // One-foot Indy
            "illustration20" => array("path" => "/public/img/one-foot-indy_01.jpg",
            ),
            "illustration21" => array("path" => "/public/img/one-foot-indy_02.jpg",
            ),
            // OLD SCHOOL
            //Japan air
            "illustration22" => array("path" => "/public/img/japan-air_01.jpg",
            ),
            "illustration23" => array("path" => "/public/img/japan-air_02.jpg",
            )
        );

        // VIDEOS ARRAY
        $videos = array(
            // GRABS
            // Nose Grab
            "video01" => array("url" => "https://www.youtube.com/watch?v=nIS14rVlbyQ",
            ),
            "video02" => array("url" => "https://www.youtube.com/watch?v=_Qq-YoXwNQY",
            ),
            // China air
            "video03" => array("url" => "https://www.youtube.com/watch?v=CA5bURVJ5zk",
            ),
            // ROTATIONS
            // 180
            "video04" => array("url" => "https://www.youtube.com/watch?v=Sj7CJH9YvAo",
            ),
            "video05" => array("url" => "https://www.youtube.com/watch?v=JMS2PGAFMcE",
            ),
            // 360
            "video06" => array("url" => "https://www.youtube.com/watch?v=GS9MMT_bNn8",
            ),
            "video07" => array("url" => "https://www.youtube.com/watch?v=grXpguVaqls",
            ),
            // FLIPS
            // Back flip
            "video08" => array("url" => "https://www.youtube.com/watch?v=SlhGVnFPTDE",
            ),
            "video09" => array("url" => "https://www.youtube.com/watch?v=arzLq-47QFA",
            ),
            // ROTATIONS DESAXEES
            // McTwist
            "video10" => array("url" => "https://www.youtube.com/watch?v=k-CoAquRSwY",
            ),
            // Misty
            "video11" => array("url" => "https://www.youtube.com/watch?v=hPuVJkw1MmI",
            ),
            "video12" => array("url" => "https://www.youtube.com/watch?v=FMHiSF0rHF8",
            ),
            // SLIDES
            // Boardslide
            "video13" => array("url" => "https://www.youtube.com/watch?v=R3OG9rNDIcs",
            ),
            "video14" => array("url" => "https://www.youtube.com/watch?v=hdqAhRO7bIw",
            ),
            "video15" => array("url" => "https://www.youtube.com/watch?v=gO5GLk7oQhU",
            ),
            // ONE FOOT TRICKS
            // One-foot Indy
            "video16" => array("url" => "https://www.youtube.com/watch?v=7WJb_igyZ5w",
            ),
            "video16" => array("url" => "https://www.youtube.com/watch?v=LWUfrwCofuA&t=8s",
            ),
            // OLD SCHOOL
            // Japan air
            "video18" => array("url" => "https://www.youtube.com/watch?v=I7N45iRPrhw",
            ),
        );

        // COMMENTS ARRAY
        $comments = array(
            "comment01" => array("content" => "Pas mal !",
            ),
            "comment02" => array("content" => "Compliqué quand même !",
            ),
            "comment03" => array("content" => "Trop cool !",
            ),
            "comment04" => array("content" => "ça à l'air dure par contre.",
            ),
            "comment05" => array("content" => "En vrai facile",
            ),
            "comment06" => array("content" => "Je comprend pas ..",
            ),
            "comment07" => array("content" => "j'ai déjà réussi celle-la",
            ),
            "comment08" => array("content" => "Je me suis cassé le bras la dernière fois que j'ai tenté celle-là..",
            ),
        );

        // TRICKS :

        // TRICK 1
        for ($t = 0; $t<=1; $t++) 
        {
            for ($u = 0; $u<=1; $u++) 
            {
                // user
                $user = new User();
                $user->setUserName($users['user01']['username'])
                    ->setEmail($users['user01']['email'])
                    ->setPassword($this->userEncoder->encodePassword($user, $users['user01']['password']));
                $manager->persist($user);
                // category
                $category = new Category();
                $category->setName($categories[0]);
                $manager->persist($category);
                //comment
                $comment = new Comment();
                $comment->setUser($user)
                        ->setContent($comments['comment01']['content']);
                $manager->persist($comment);
            }
            for ($u = 0; $u<=1; $u++) 
            {
                // user
                $user = new User();
                $user->setUserName($users['user01']['username'])
                    ->setEmail($users['user01']['email'])
                    ->setPassword($this->userEncoder->encodePassword($user, $users['user01']['password']));
                $manager->persist($user);
                // category
                $category = new Category();
                $category->setName($categories[0]);
                $manager->persist($category);
                //comment
                $comment = new Comment();
                $comment->setUser($user)
                        ->setContent($comments['comment06']['content']);
                $manager->persist($comment);
            }
            //illustrations
            for ($i = 0; $i <= 1; $i++) 
            {
                $illustration = new Illustration();
                $illustration->setPath($illustrations['illustration01']['path']);
                $manager->persist($illustration);
            }
            for ($i = 0; $i <= 1; $i++) 
            {
                $illustration = new Illustration();
                $illustration->setPath($illustrations['illustration02']['path']);
                $manager->persist($illustration);
            }
            for ($i = 0; $i <= 1; $i++) 
            {
                $illustration = new Illustration();
                $illustration->setPath($illustrations['illustration03']['path']);
                $manager->persist($illustration);
            }
            for ($i = 0; $i <= 1; $i++) 
            {
                $illustration = new Illustration();
                $illustration->setPath($illustrations['illustration04']['path']);
                $manager->persist($illustration);
            }
            for ($i = 0; $i <= 1; $i++) 
            {
                $illustration = new Illustration();
                $illustration->setPath($illustrations['illustration05']['path']);
                $manager->persist($illustration);
            }
            // videos
            for ($v = 0; $v <= 1; $v++) 
            {
                $video = new Video();
                $video->setUrl($videos['video01']['url']);
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
                $manager->persist($video);
            }
            for ($v = 0; $v <= 1; $v++) 
            {
                $video = new Video();
                $video->setUrl($videos['video02']['url']);
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
                $manager->persist($video);
            }
            for ($v = 0; $v <= 1; $v++) 
            {
                $video = new Video();
                $video->setUrl($videos['video03']['url']);
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
                $manager->persist($video);
            }           
            // trick
            $trick = new Trick();
            $trick->setUser($user)
                    -> setCategory($category)
                    -> setName($tricks['trick01']['name'])
                    -> setDescription($tricks['trick01']['description'])
                    ->addIllustration($illustration)
                    ->addVideo($video)
                    ->addComment($comment);
            $manager->persist($trick);
        }
        $manager->flush();
    }
}