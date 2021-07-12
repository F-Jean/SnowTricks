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
        /*
            !! Faire correspondre les bonnes images et bonnes videos aux bonnes figures !! 
        */

        // ARRAYS :
        // USERS ARRAY
        $users = array(
            "user1" => array("email" => "jean@symfony.com",
                            "username" => "fjean",
                            "avatar" => "cheminDuFichier?",
                            "password" => "Password1"
            ),
            "user2" => array("email" => "loic@orange.com",
                            "username" => "lolo",
                            "avatar" => "cheminDuFichier?",
                            "password" => "Password2"
            ),
            "user3" => array("email" => "antoine@gmail.com",
                            "username" => "tonio",
                            "avatar" => "cheminDuFichier?",
                            "password" => "Password3"
            ),
            "user4" => array("email" => "claire@symfony.com",
                            "username" => "claire",
                            "avatar" => "cheminDuFichier?",
                            "password" => "Password4"
            ),
            "user5" => array("email" => "muriel@hotmail.fr",
                            "username" => "murielf",
                            "avatar" => "cheminDuFichier?",
                            "password" => "Password5"
            ),
            "user6" => array("email" => "marie@symfony.com",
                            "username" => "marie",
                            "avatar" => "cheminDuFichier?",
                            "password" => "Password6"
            ),
            "user7" => array("email" => "foriane@gmail.com",
                            "username" => "floflo",
                            "avatar" => "cheminDuFichier?",
                            "password" => "Password7"
            ),
            "user8" => array("email" => "john@symfony.com",
                            "username" => "bigJ",
                            "avatar" => "cheminDuFichier?",
                            "password" => "Password8"
            ),
            "user9" => array("email" => "fred@hotmail.fr",
                            "username" => "fredou",
                            "avatar" => "cheminDuFichier?",
                            "password" => "Password9"
            ),
            "user10" => array("email" => "franck@gmail.com.com",
                            "username" => "francky",
                            "avatar" => "cheminDuFichier?",
                            "password" => "Password10"
            )
        );
        // CATEGORIES ARRAY
        $categories = array("Grabs", "Rotations", "Flips", "Rotations désaxées", "Slides", "One foot tricks", "Old school");
        
        // TRICKS ARRAY
        $tricks = array(
            // Grabs
            "trick1" => array("name" => "Nose Grab",
                            "description" => "La main avant grab le bout avant (nose) de la board. Levez votre jambe avant et étendez votre jambe arrière pour amener votre board vers votre main.</br>
                            Un grab consiste à attraper la planche avec la main pendant le saut. Le verbe anglais to grab signifie « attraper. »</br>
                            Il existe plusieurs types de grabs selon la position de la saisie et la main choisie pour l'effectuer.</br>
                            Un grab est d'autant plus réussi que la saisie est longue. De plus, le saut est d'autant plus esthétique que la saisie du snowboard est franche, ce qui permet au rideur d'accentuer la torsion de son corps grâce à la tension de sa main sur la planche. On dit alors que le grab est tweaké (le verbe anglais to tweak signifie « pincer » mais a également le sens de « peaufiner »).",
            ),
            "trick2" => array("name" => "Canadian bacon",
                            "description" => "La main arrière grab la carre front en passant la main derrière la jambe arrière.</br>
                            Un grab consiste à attraper la planche avec la main pendant le saut. Le verbe anglais to grab signifie « attraper. »</br>
                            Il existe plusieurs types de grabs selon la position de la saisie et la main choisie pour l'effectuer.</br>
                            Un grab est d'autant plus réussi que la saisie est longue. De plus, le saut est d'autant plus esthétique que la saisie du snowboard est franche, ce qui permet au rideur d'accentuer la torsion de son corps grâce à la tension de sa main sur la planche. On dit alors que le grab est tweaké (le verbe anglais to tweak signifie « pincer » mais a également le sens de « peaufiner »).",
            ),
            "trick3" => array("name" => "Truck driver",
                            "description" => "Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture).</br>
                            Un grab consiste à attraper la planche avec la main pendant le saut. Le verbe anglais to grab signifie « attraper. »</br>
                            Il existe plusieurs types de grabs selon la position de la saisie et la main choisie pour l'effectuer.</br>
                            Un grab est d'autant plus réussi que la saisie est longue. De plus, le saut est d'autant plus esthétique que la saisie du snowboard est franche, ce qui permet au rideur d'accentuer la torsion de son corps grâce à la tension de sa main sur la planche. On dit alors que le grab est tweaké (le verbe anglais to tweak signifie « pincer » mais a également le sens de « peaufiner »).",
            ),
            // Rotations
            "trick4" => array("name" => "180",
                            "description" => "Un demi-tour, soit 180 degrés d'angle.</br>
                            Le principe est d'effectuer une rotation horizontale pendant le saut, puis d'attérir en position switch ou normal. La nomenclature se base sur le nombre de degrés de rotation effectués.</br>
                            Une rotation peut être frontside ou backside : une rotation frontside correspond à une rotation orientée vers la carre backside. Cela peut paraître incohérent mais l'origine étant que dans un halfpipe ou une rampe de skateboard, une rotation frontside se déclenche naturellement depuis une position frontside (i.e. l'appui se fait sur la carre frontside), et vice-versa. Ainsi pour un rider qui a une position regular (pied gauche devant), une rotation frontside se fait dans le sens inverse des aiguilles d'une montre.</br>
                            Une rotation peut être agrémentée d'un grab, ce qui rend le saut plus esthétique mais aussi plus difficile car la position tweakée a tendance à déséquilibrer le rideur et désaxer la rotation. De plus, le sens de la rotation a tendance à favoriser un sens de grab plutôt qu'un autre. Les rotations de plus de trois tours existent mais sont plus rares, d'abord parce que les modules assez gros pour lancer un tel saut sont rares, et ensuite parce que la vitesse de rotation est tellement élevée qu'un grab devient difficile, ce qui rend le saut considérablement moins esthétique.",
            ),
            "trick5" => array("name" => "360",
                            "description" => "360, ou trois six pour un tour complet.</br>
                            Le principe est d'effectuer une rotation horizontale pendant le saut, puis d'attérir en position switch ou normal. La nomenclature se base sur le nombre de degrés de rotation effectués.</br>
                            Une rotation peut être frontside ou backside : une rotation frontside correspond à une rotation orientée vers la carre backside. Cela peut paraître incohérent mais l'origine étant que dans un halfpipe ou une rampe de skateboard, une rotation frontside se déclenche naturellement depuis une position frontside (i.e. l'appui se fait sur la carre frontside), et vice-versa. Ainsi pour un rider qui a une position regular (pied gauche devant), une rotation frontside se fait dans le sens inverse des aiguilles d'une montre.</br>
                            Une rotation peut être agrémentée d'un grab, ce qui rend le saut plus esthétique mais aussi plus difficile car la position tweakée a tendance à déséquilibrer le rideur et désaxer la rotation. De plus, le sens de la rotation a tendance à favoriser un sens de grab plutôt qu'un autre. Les rotations de plus de trois tours existent mais sont plus rares, d'abord parce que les modules assez gros pour lancer un tel saut sont rares, et ensuite parce que la vitesse de rotation est tellement élevée qu'un grab devient difficile, ce qui rend le saut considérablement moins esthétique.",
            ),
            "trick6" => array("name" => "540",
                            "description" => "540, ou cinq quatre pour un tour et demi.</br>
                            Le principe est d'effectuer une rotation horizontale pendant le saut, puis d'attérir en position switch ou normal. La nomenclature se base sur le nombre de degrés de rotation effectués.</br>
                            Une rotation peut être frontside ou backside : une rotation frontside correspond à une rotation orientée vers la carre backside. Cela peut paraître incohérent mais l'origine étant que dans un halfpipe ou une rampe de skateboard, une rotation frontside se déclenche naturellement depuis une position frontside (i.e. l'appui se fait sur la carre frontside), et vice-versa. Ainsi pour un rider qui a une position regular (pied gauche devant), une rotation frontside se fait dans le sens inverse des aiguilles d'une montre.</br>
                            Une rotation peut être agrémentée d'un grab, ce qui rend le saut plus esthétique mais aussi plus difficile car la position tweakée a tendance à déséquilibrer le rideur et désaxer la rotation. De plus, le sens de la rotation a tendance à favoriser un sens de grab plutôt qu'un autre. Les rotations de plus de trois tours existent mais sont plus rares, d'abord parce que les modules assez gros pour lancer un tel saut sont rares, et ensuite parce que la vitesse de rotation est tellement élevée qu'un grab devient difficile, ce qui rend le saut considérablement moins esthétique.",
            ),
            "trick7" => array("name" => "720",
                            "description" => "720, ou sept deux pour deux tours complets.</br>
                            Le principe est d'effectuer une rotation horizontale pendant le saut, puis d'attérir en position switch ou normal. La nomenclature se base sur le nombre de degrés de rotation effectués.</br>
                            Une rotation peut être frontside ou backside : une rotation frontside correspond à une rotation orientée vers la carre backside. Cela peut paraître incohérent mais l'origine étant que dans un halfpipe ou une rampe de skateboard, une rotation frontside se déclenche naturellement depuis une position frontside (i.e. l'appui se fait sur la carre frontside), et vice-versa. Ainsi pour un rider qui a une position regular (pied gauche devant), une rotation frontside se fait dans le sens inverse des aiguilles d'une montre.</br>
                            Une rotation peut être agrémentée d'un grab, ce qui rend le saut plus esthétique mais aussi plus difficile car la position tweakée a tendance à déséquilibrer le rideur et désaxer la rotation. De plus, le sens de la rotation a tendance à favoriser un sens de grab plutôt qu'un autre. Les rotations de plus de trois tours existent mais sont plus rares, d'abord parce que les modules assez gros pour lancer un tel saut sont rares, et ensuite parce que la vitesse de rotation est tellement élevée qu'un grab devient difficile, ce qui rend le saut considérablement moins esthétique.",
            ),
            "trick8" => array("name" => "900",
                            "description" => "Deux tours et demi.</br>
                            Le principe est d'effectuer une rotation horizontale pendant le saut, puis d'attérir en position switch ou normal. La nomenclature se base sur le nombre de degrés de rotation effectués.</br>
                            Une rotation peut être frontside ou backside : une rotation frontside correspond à une rotation orientée vers la carre backside. Cela peut paraître incohérent mais l'origine étant que dans un halfpipe ou une rampe de skateboard, une rotation frontside se déclenche naturellement depuis une position frontside (i.e. l'appui se fait sur la carre frontside), et vice-versa. Ainsi pour un rider qui a une position regular (pied gauche devant), une rotation frontside se fait dans le sens inverse des aiguilles d'une montre.</br>
                            Une rotation peut être agrémentée d'un grab, ce qui rend le saut plus esthétique mais aussi plus difficile car la position tweakée a tendance à déséquilibrer le rideur et désaxer la rotation. De plus, le sens de la rotation a tendance à favoriser un sens de grab plutôt qu'un autre. Les rotations de plus de trois tours existent mais sont plus rares, d'abord parce que les modules assez gros pour lancer un tel saut sont rares, et ensuite parce que la vitesse de rotation est tellement élevée qu'un grab devient difficile, ce qui rend le saut considérablement moins esthétique.",
            ),
            "trick9" => array("name" => "1080",
                            "description" => "1080, ou big foot pour trois tours.</br>
                            Le principe est d'effectuer une rotation horizontale pendant le saut, puis d'attérir en position switch ou normal. La nomenclature se base sur le nombre de degrés de rotation effectués.</br>
                            Une rotation peut être frontside ou backside : une rotation frontside correspond à une rotation orientée vers la carre backside. Cela peut paraître incohérent mais l'origine étant que dans un halfpipe ou une rampe de skateboard, une rotation frontside se déclenche naturellement depuis une position frontside (i.e. l'appui se fait sur la carre frontside), et vice-versa. Ainsi pour un rider qui a une position regular (pied gauche devant), une rotation frontside se fait dans le sens inverse des aiguilles d'une montre.</br>
                            Une rotation peut être agrémentée d'un grab, ce qui rend le saut plus esthétique mais aussi plus difficile car la position tweakée a tendance à déséquilibrer le rideur et désaxer la rotation. De plus, le sens de la rotation a tendance à favoriser un sens de grab plutôt qu'un autre. Les rotations de plus de trois tours existent mais sont plus rares, d'abord parce que les modules assez gros pour lancer un tel saut sont rares, et ensuite parce que la vitesse de rotation est tellement élevée qu'un grab devient difficile, ce qui rend le saut considérablement moins esthétique.",
            ),
            // Flips
            "trick10" => array("name" => "Back flip",
                            "description" => "Rotation verticale en arrière lors d'un saut. Il est possible de faire plusieurs flips à la suite, et d'ajouter un grab à la rotation.</br>
                            Les flips agrémentés d'une vrille existent aussi (Mac Twist, Hakon Flip...), mais de manière beaucoup plus rare, et se confondent souvent avec certaines rotations horizontales désaxées.</br> 
                            Néanmoins, en dépit de la difficulté technique relative d'une telle figure, le danger de retomber sur la tête ou la nuque est réel et conduit certaines stations de ski à interdire de telles figures dans ses snowparks.",
            ),
            "trick11" => array("name" => "Front flip",
                            "description" => "Rotation verticale en avant lors d'un saut.</br>
                            Les flips agrémentés d'une vrille existent aussi (Mac Twist, Hakon Flip...), mais de manière beaucoup plus rare, et se confondent souvent avec certaines rotations horizontales désaxées.</br> 
                            Néanmoins, en dépit de la difficulté technique relative d'une telle figure, le danger de retomber sur la tête ou la nuque est réel et conduit certaines stations de ski à interdire de telles figures dans ses snowparks.",
            ),
            // Rotations désaxées
            "trick12" => array("name" => "Corkscrew",
                            "description" => "L'axe de la rotation permet au snwoboarder d'être orienté de côté ou la tête à l'envers lors d'un saut, sans vraiment être complètement inversé (bien que la tête et les épaules devrait être suffisament sous le niveau du board.</br>
                            Une rotation désaxée est une rotation initialement horizontale mais lancée avec un mouvement des épaules particulier qui désaxe la rotation.</br>
                            Certaines de ces rotations, bien qu'initialement horizontales, font passer la tête en bas.</br>
                            Bien que certaines de ces rotations soient plus faciles à faire sur un certain nombre de tours (ou de demi-tours) que d'autres, il est en théorie possible de d'attérir n'importe quelle rotation désaxée avec n'importe quel nombre de tours, en jouant sur la quantité de désaxage afin de se retrouver à la position verticale au moment voulu.</br>
                            Il est également possible d'agrémenter une rotation désaxée par un grab.)",
            ),
            "trick13" => array("name" => "Misty",
                            "description" => "Le Misty Flip est une rotation arrière hors axe 540.</br>
                            Une rotation désaxée est une rotation initialement horizontale mais lancée avec un mouvement des épaules particulier qui désaxe la rotation.</br>
                            Certaines de ces rotations, bien qu'initialement horizontales, font passer la tête en bas.</br>
                            Bien que certaines de ces rotations soient plus faciles à faire sur un certain nombre de tours (ou de demi-tours) que d'autres, il est en théorie possible de d'attérir n'importe quelle rotation désaxée avec n'importe quel nombre de tours, en jouant sur la quantité de désaxage afin de se retrouver à la position verticale au moment voulu.</br>
                            Il est également possible d'agrémenter une rotation désaxée par un grab.)",
            ),
            // Slides
            "trick14" => array("name" => "",
                            "description" => "",
            ),
            "trick15" => array("name" => "",
                            "description" => "",
            ),
            "trick16" => array("name" => "",
                            "description" => "",
            ),
            "trick17" => array("name" => "",
                            "description" => "",
            ),
            "trick18" => array("name" => "",
                            "description" => "",
            ),
            // One foot tricks
            "trick19" => array("name" => "",
                            "description" => "",
            ),
            "trick20" => array("name" => "",
                            "description" => "",
            ),
            "trick21" => array("name" => "",
                            "description" => "",
            ),
            "trick22" => array("name" => "",
                            "description" => "",
            ),
            // Old school
            "trick23" => array("name" => "Japan air",
                            "description" => "La main avant grab la carre front au niveau de la fix avant, les genoux sont pliés, et la board est tirée vers le haut.</br>
                            Un grab consiste à attraper la planche avec la main pendant le saut. Le verbe anglais to grab signifie « attraper. »</br>
                            Il existe plusieurs types de grabs selon la position de la saisie et la main choisie pour l'effectuer.</br>
                            Un grab est d'autant plus réussi que la saisie est longue. De plus, le saut est d'autant plus esthétique que la saisie du snowboard est franche, ce qui permet au rideur d'accentuer la torsion de son corps grâce à la tension de sa main sur la planche. On dit alors que le grab est tweaké (le verbe anglais to tweak signifie « pincer » mais a également le sens de « peaufiner »).",
            )
        );

        // ILLUSTRATIONS ARRAY
        $illustrations = array(
            // Nose Grab
            "illustration1" => array("path" => "",
            ),
            "illustration2" => array("path" => "",
            ),
            "illustration3" => array("path" => "",
            ),
            // Canadian bacon
            "illustration4" => array("path" => "",
            ),
            "illustration5" => array("path" => "",
            ),
            // Rotations
            "illustration6" => array("path" => "",
            ),
            "illustration7" => array("path" => "",
            ),
            "illustration8" => array("path" => "",
            ),
            "illustration9" => array("path" => "",
            ),
            // Flips
            "illustration10" => array("path" => "",
            ),
            "illustration11" => array("path" => "",
            ),
            "illustration12" => array("path" => "",
            ),
            "illustration13" => array("path" => "",
            ),
            "illustration14" => array("path" => "",
            ),
            "illustration15" => array("path" => "",
            ),
            "illustration16" => array("path" => "",
            ),
            // Rotations désaxées
            "illustration17" => array("path" => "",
            ),
            "illustration18" => array("path" => "",
            ),
            "illustration19" => array("path" => "",
            ),
            // Slides
            "illustration20" => array("path" => "",
            ),
            "illustration21" => array("path" => "",
            ),
            "illustration22" => array("path" => "",
            ),
            // One foot tricks
            "illustration23" => array("path" => "",
            ),
            "illustration24" => array("path" => "",
            ),
            "illustration25" => array("path" => "",
            ),
            // Old school
            "illustration26" => array("path" => "",
            ),
            "illustration27" => array("path" => "",
            )
        );

        // VIDEOS ARRAY
        $videos = array(
            // Grabs
            "video1" => array("url" => "",
            ),
            "video2" => array("url" => "",
            ),
            "video3" => array("url" => "",
            ),
            // Rotations
            "video4" => array("url" => "",
            ),
            "video5" => array("url" => "",
            ),
            "video6" => array("url" => "",
            ),
            "video7" => array("url" => "",
            ),
            "video8" => array("url" => "",
            ),
            "video9" => array("url" => "",
            ),
            // Flips
            "video10" => array("url" => "",
            ),
            "video11" => array("url" => "",
            ),
            // Rotations désaxées
            "video12" => array("url" => "",
            ),
            "video13" => array("url" => "",
            ),
            "video14" => array("url" => "",
            ),
            "video15" => array("url" => "",
            ),
            // Slides
            "video16" => array("url" => "",
            ),
            "video17" => array("url" => "",
            ),
            "video18" => array("url" => "",
            ),
            "video19" => array("url" => "",
            ),
            "video20" => array("url" => "",
            ),
            // One foot tricks
            "video21" => array("url" => "",
            ),
            "video22" => array("url" => "",
            ),
            // Old school
            "video23" => array("url" => "",
            ),
        );

        // COMMENTS ARRAY
        $comments = array(
            "comment1" => array("content" => "Pas mal !",
            ),
            "comment2" => array("content" => "Compliqué quand même !",
            ),
            "comment3" => array("content" => "Trop cool !",
            ),
            "comment4" => array("content" => "ça à l'air dure par contre.",
            ),
            "comment5" => array("content" => "En vrai facile",
            ),
            "comment6" => array("content" => "Je comprend pas ..",
            ),
            "comment7" => array("content" => "j'ai déjà réussi celle-la",
            ),
            "comment8" => array("content" => "Je me suis cassé le bras la dernière fois que j'ai tenté celle-là..",
            ),
        );

        // LOOP :
        // USERS
        foreach ($users as $value) {
            $user = new User();
            $user->setUserName($value['userName'])
                ->setAvatar($value['avatar'])
                ->setEmail($value['email'])
                ->setPassword($this->userEncoder->encodePassword($user, $value['password']));
            $manager->persist($user);
        }

        // CATEGORIES
        foreach ($categories as $group) {
            $category = new Category();
            $category -> setName($group);
            $manager->persist($category);

            // TRICK 1
            for($t = 0; $t<=1; $t++){
                $trick = new Trick();
                $trick -> setName($tricks['trick1']['name']);
                $trick -> setCategory($category);
                $trick -> setDescription($tricks['trick1']['description']);
                $trick -> setAddedAt(new \DateTimeImmutable());
                $manager->persist($trick);

                // ILLUSTRATIONS
                for ($i = 1; $i <= 4; $i++) {
                    $illustration = new Illustration();
                    $illustration->setPath($i['path']);
                    $trick->addIllustration($illustration);
                    $manager->persist($illustration);
                }

                //VIDEOS
                for($v = 0; $v <= 1; $v++) {
                    $video = new Video();
                    $video->setUrl($videos['video1']['url']);
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
                    for ($c = 0; $c <= 1; $c++) {
                        $comment = new Comment();
                        $comment->setUser($user);
                        $comment->setTrick($trick)
                        ->setPostedAt(new \DateTimeImmutable())
                        ->setContent($c['content']);
                        $manager->persist($comment);
                    }
                }
            }
            $manager->flush();
        }
    }
}