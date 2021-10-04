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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;


class TrickFixtures extends Fixture
{
    private $userEncoder;
    protected $slugger;

    public function __construct(UserPasswordHasherInterface $passwordHasher, SluggerInterface $slugger)
    {

        $this->passwordHasher = $passwordHasher;
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager)
    {
        $users = [
            'fjean' => (new User())->setUsername('fjean')->setEmail('fjean@symfony.com'), 
            'marie' => (new User())->setUsername('marie')->setEmail('marie@symfony.com'),
            'antoine' => (new User())->setUsername('antoine')->setEmail('antoine@symfony.com'),
            'john' => (new User())->setUsername('john')->setEmail('john@symfony.com'),
            'loic' => (new User())->setUsername('loic')->setEmail('loic@symfony.com'),
            'claire' => (new User())->setUsername('claire')->setEmail('claire@symfony.com')
        ];

        foreach ($users as $user) {
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
            $user->setAvatar('basicAvatar.png');
            $user->setEnabled("1");
            $manager->persist($user);
        }

        $comments = [
            '1' => (new Comment())->setContent("ça à l'air dure par contre.")->setUser($users['fjean']), 
            '2' => (new Comment())->setContent("En vrai facile")->setUser($users['marie']),
            '3' => (new Comment())->setContent("j'ai déjà réussi celle-la")->setUser($users['antoine']),
            '4' => (new Comment())->setContent("Je me suis cassé le bras la dernière fois que j'ai tenté celle-là..")->setUser($users['john']),
            '5' => (new Comment())->setContent("Mouaih pas mal !!")->setUser($users['loic']),
            '6' => (new Comment())->setContent("Tranquille !")->setUser($users['claire']),
            '7' => (new Comment())->setContent("Facile !")->setUser($users['antoine']),
            '8' => (new Comment())->setContent("Trop cool !")->setUser($users['fjean']),
            '9' => (new Comment())->setContent("Dites moi ce que vous pensez de celle-là.")->setUser($users['claire']),
            '10' => (new Comment())->setContent("Pas mal !")->setUser($users['john']),
            '11' => (new Comment())->setContent("Pas sûr que je l'essai celle-là !!!")->setUser($users['loic']),
            '12' => (new Comment())->setContent("Je comprend pas ..")->setUser($users['fjean']),
            '13' => (new Comment())->setContent("Les yeux fermés, easy.")->setUser($users['claire']),
            '14' => (new Comment())->setContent("J'aime pas la faire celle-la.")->setUser($users['antoine']),
            '15' => (new Comment())->setContent("Moui elle est dure à rentrer.")->setUser($users['john']),
            '16' => (new Comment())->setContent("J'avoue !")->setUser($users['claire']),
            '17' => (new Comment())->setContent("J'aime bien les slides aussi !")->setUser($users['loic']),
            '18' => (new Comment())->setContent("Au début on aime pas forcément ehehe!")->setUser($users['fjean']),
            '19' => (new Comment())->setContent("Bah ça viendra tkt !")->setUser($users['antoine']),
            '20' => (new Comment())->setContent("Mais oui, mais oui !")->setUser($users['fjean']),
            '21' => (new Comment())->setContent("Même pas en rêve !")->setUser($users['loic']),
            '22' => (new Comment())->setContent("Juste une question d'entrainement, comme d'hab")->setUser($users['john']),
            '23' => (new Comment())->setContent("Les jump, y'a quand même rien de mieux je trouve")->setUser($users['antoine']),
            '24' => (new Comment())->setContent("Pour bien s'éclater oui c'est sûr !!!!")->setUser($users['claire']),
            '25' => (new Comment())->setContent("Je trouve ça jolie les rotations moi")->setUser($users['john']),
            '26' => (new Comment())->setContent("Une figure de base.")->setUser($users['fjean']),
            '27' => (new Comment())->setContent("Pas mal pour les débutants")->setUser($users['loic']),
            '28' => (new Comment())->setContent("Moi perso quand j'ai débuter je faisais pas ça !!")->setUser($users['marie']),
            '29' => (new Comment())->setContent("Pas vraiment pour les grands débutants c'est sur")->setUser($users['antoine']),
            '30' => (new Comment())->setContent("Si elle est bien rentré oui ça peut être classe")->setUser($users['john'])
        ];

        $categories = [
            "Grabs" => [
                [
                    "name" => "Nose Grab",
                    "description" => "La main avant grab le bout avant (nose) de la board. 
Levez votre jambe avant et étendez votre jambe arrière pour amener votre board vers votre main. Un grab consiste à attraper la planche avec la main pendant le saut. 
Le verbe anglais to grab signifie « attraper. » Il existe plusieurs types de grabs selon la position de la saisie et la main choisie pour l'effectuer.
Un grab est d'autant plus réussi que la saisie est longue. De plus, le saut est d'autant plus esthétique que la saisie du snowboard est franche, ce qui permet au rideur d'accentuer la torsion de son corps grâce à la tension de sa main sur la planche. 
On dit alors que le grab est tweaké (le verbe anglais to tweak signifie « pincer » mais a également le sens de « peaufiner »).",
                    "illustrations" => [
                        "nose-grab_01.jpg",
                        "nose-grab_02.jpg",
                        "nose-grab_03.jpg"
                    ],
                    "videos" => [
                        "https://www.youtube.com/watch?v=nIS14rVlbyQ",
                        "https://www.youtube.com/watch?v=_Qq-YoXwNQY"
                    ],
                    "user" => $users["fjean"],
                    "comments" => [$comments[ "26"], $comments["27"], $comments["28"], $comments["29"]]      
                ],
                [
                    "name" => "China air",
                    "description" => "La main avant grab la partie avant du snowboard. Les deux genoux sont pliés.",
                    "illustrations" => [
                        "china-air_01.jpg",
                        "china-air_02.jpg"
                    ],
                    "videos" => [
                        "https://www.youtube.com/watch?v=CA5bURVJ5zk"
                    ],
                    "user" => $users["loic"],
                    "comments" => [$comments[ "1"], $comments["2"]]         
                ]
            ],
            "Rotations" => [
                [
                    "name" => "180",
                    "description" => "Un demi-tour, soit 180 degrés d'angle.
Le principe est d'effectuer une rotation horizontale pendant le saut, puis d'attérir en position switch ou normal. La nomenclature se base sur le nombre de degrés de rotation effectués.
Une rotation peut être frontside ou backside : une rotation frontside correspond à une rotation orientée vers la carre backside. Cela peut paraître incohérent mais l'origine étant que dans un halfpipe ou une rampe de skateboard, une rotation frontside se déclenche naturellement depuis une position frontside (i.e. l'appui se fait sur la carre frontside), et vice-versa. 
Ainsi pour un rider qui a une position regular (pied gauche devant), une rotation frontside se fait dans le sens inverse des aiguilles d'une montre.
Une rotation peut être agrémentée d'un grab, ce qui rend le saut plus esthétique mais aussi plus difficile car la position tweakée a tendance à déséquilibrer le rideur et désaxer la rotation. De plus, le sens de la rotation a tendance à favoriser un sens de grab plutôt qu'un autre. 
Les rotations de plus de trois tours existent mais sont plus rares, d'abord parce que les modules assez gros pour lancer un tel saut sont rares, et ensuite parce que la vitesse de rotation est tellement élevée qu'un grab devient difficile, ce qui rend le saut considérablement moins esthétique.",
                    "illustrations" => [
                        "180_01.jpeg",
                        "180_02.jpg"
                    ],
                    "videos" => [
                        "https://www.youtube.com/watch?v=Sj7CJH9YvAo",
                        "https://www.youtube.com/watch?v=JMS2PGAFMcE"
                    ],
                    "user" => $users["marie"],
                    "comments" => [$comments[ "7"]]
                ],
                [
                    "name" => "360",
                    "description" => "360, ou trois six pour un tour complet.
Le principe est d'effectuer une rotation horizontale pendant le saut, puis d'attérir en position switch ou normal. La nomenclature se base sur le nombre de degrés de rotation effectués.
Une rotation peut être frontside ou backside : une rotation frontside correspond à une rotation orientée vers la carre backside. 
Cela peut paraître incohérent mais l'origine étant que dans un halfpipe ou une rampe de skateboard, une rotation frontside se déclenche naturellement depuis une position frontside (i.e. l'appui se fait sur la carre frontside), et vice-versa. Ainsi pour un rider qui a une position regular (pied gauche devant), une rotation frontside se fait dans le sens inverse des aiguilles d'une montre.
Une rotation peut être agrémentée d'un grab, ce qui rend le saut plus esthétique mais aussi plus difficile car la position tweakée a tendance à déséquilibrer le rideur et désaxer la rotation. De plus, le sens de la rotation a tendance à favoriser un sens de grab plutôt qu'un autre. 
Les rotations de plus de trois tours existent mais sont plus rares, d'abord parce que les modules assez gros pour lancer un tel saut sont rares, et ensuite parce que la vitesse de rotation est tellement élevée qu'un grab devient difficile, ce qui rend le saut considérablement moins esthétique.",
                    "illustrations" => [
                        "360_01.jpg",
                        "360_02.jpg"
                    ],
                    "videos" => [
                        "https://www.youtube.com/watch?v=GS9MMT_bNn8",
                        "https://www.youtube.com/watch?v=grXpguVaqls"
                    ],
                    "user" => $users["john"],
                    "comments" => [$comments[ "25"], $comments["30"]]          
                ]
            ],
            "Flips" => [
                [
                    "name" => "Back flip",
                    "description" => "Rotation verticale en arrière lors d'un saut. Il est possible de faire plusieurs flips à la suite, et d'ajouter un grab à la rotation.
Les flips agrémentés d'une vrille existent aussi (Mac Twist, Hakon Flip...), mais de manière beaucoup plus rare, et se confondent souvent avec certaines rotations horizontales désaxées. 
Néanmoins, en dépit de la difficulté technique relative d'une telle figure, le danger de retomber sur la tête ou la nuque est réel et conduit certaines stations de ski à interdire de telles figures dans ses snowparks.",
                    "illustrations" => [
                        "backflip_01.jpeg",
                        "backflip_02.jpeg",
                        "backflip_03.jpg",
                        "backflip_04.jpg"
                    ],
                    "videos" => [
                        "https://www.youtube.com/watch?v=Sj7CJH9YvAo",
                        "https://www.youtube.com/watch?v=JMS2PGAFMcE"
                    ],
                    "user" => $users["claire"],
                    "comments" => [$comments[ "3"], $comments["4"], $comments["6"]]          
                ]               
            ],
            "Rotations désaxées" => [
                [
                    "name" => "McTwist",
                    "description" => "Un backside 540 avant-flip, exécuté dans un half-pipe, un quarterpipe ou un obstacle similaire.",
                    "illustrations" => [
                        "McTwist_01.jpeg",
                        "McTwist_02.jpg"
                    ],
                    "videos" => [
                        "https://www.youtube.com/watch?v=k-CoAquRSwY"
                    ],
                    "user" => $users["antoine"],
                    "comments" => [$comments[ "9"], $comments["5"], $comments["11"], $comments["13"]]          
                ],
                [
                    "name" => "Misty",
                    "description" => "Le Misty Flip est une rotation arrière hors axe 540.
Une rotation désaxée est une rotation initialement horizontale mais lancée avec un mouvement des épaules particulier qui désaxe la rotation.
Certaines de ces rotations, bien qu'initialement horizontales, font passer la tête en bas.
Bien que certaines de ces rotations soient plus faciles à faire sur un certain nombre de tours (ou de demi-tours) que d'autres, il est en théorie possible de d'attérir n'importe quelle rotation désaxée avec n'importe quel nombre de tours, en jouant sur la quantité de désaxage afin de se retrouver à la position verticale au moment voulu.
Il est également possible d'agrémenter une rotation désaxée par un grab.)",
                    "illustrations" => [
                        "misty.jpg"
                    ],
                    "videos" => [
                        "https://www.youtube.com/watch?v=hPuVJkw1MmI",
                        "https://www.youtube.com/watch?v=FMHiSF0rHF8"
                    ],
                    "user" => $users["fjean"],
                    "comments" => [$comments[ "8"], $comments["10"]]          
                ]              
            ],
            "Slides" => [
                [
                    "name" => "Boardslide",
                    "description" => "Une glissade effectuée où le pied fort du snowboarder passe au-dessus du rail à l'approche, avec son snowboard se déplaçant perpendiculairement le long du rail ou d'un autre obstacle. 
Lors de l'exécution d'un boardslide frontside, le snowboarder fait face à la montée. Lors de l'exécution d'un backside boardslide, un snowboarder fait face à la descente. 
C'est souvent déroutant pour les nouveaux riders qui apprennent le trick car avec un boardslide frontside vous reculez et avec un boardslide backside vous avancez.",
                    "illustrations" => [
                        "slide_01.jpg",
                        "slide_02.jpeg",
                        "slide_03.jpg"
                    ],
                    "videos" => [
                        "https://www.youtube.com/watch?v=R3OG9rNDIcs",
                        "https://www.youtube.com/watch?v=hdqAhRO7bIw",
                        "https://www.youtube.com/watch?v=gO5GLk7oQhU"
                    ],
                    "user" => $users["loic"],
                    "comments" => [$comments[ "17"], $comments["18"], $comments["19"], $comments["20"]]
                ]              
            ],
            "One foot tricks" => [
                [
                    "name" => "One-foot Indy",
                    "description" => "Lors du saut la main arrière grab la partie arrière du snowboard ou le pied arrière a été détaché. 
La jambe arrière est écarté vers l'arrière du snowboard avant de revenir en place avant la fin du saut en restant toujours détaché.",
                    "illustrations" => [
                        "one-foot-indy_01.jpg",
                        "one-foot-indy_02.jpeg"
                    ],
                    "videos" => [
                        "https://www.youtube.com/watch?v=7WJb_igyZ5w",
                        "https://www.youtube.com/watch?v=LWUfrwCofuA&t=8s"
                    ],
                    "user" => $users["fjean"],
                    "comments" => [$comments[ "21"], $comments["22"]]
                ]              
            ],
            "Old school" => [
                [
                    "name" => "Japan air",
                    "description" => "La main avant grab la carre front au niveau de la fix avant, les genoux sont pliés, et la board est tirée vers le haut.
Un grab consiste à attraper la planche avec la main pendant le saut. Le verbe anglais to grab signifie « attraper. »
Il existe plusieurs types de grabs selon la position de la saisie et la main choisie pour l'effectuer.
Un grab est d'autant plus réussi que la saisie est longue. De plus, le saut est d'autant plus esthétique que la saisie du snowboard est franche, ce qui permet au rideur d'accentuer la torsion de son corps grâce à la tension de sa main sur la planche. On dit alors que le grab est tweaké (le verbe anglais to tweak signifie « pincer » mais a également le sens de « peaufiner »).",
                    "illustrations" => [
                            "japan-air_01.jpg",
                            "japan-air_02.jpg"
                    ],
                    "videos" => [
                        "https://www.youtube.com/watch?v=I7N45iRPrhw",
                    ],
                    "user" => $users["claire"],
                    "comments" => [$comments[ "12"], $comments["14"], $comments["15"]]
                ]         
            ]
        ];

        foreach ($categories as $categoryName => $tricks) {
            $category = new Category();
            $category->setName($categoryName);

            $manager->persist($category);

            foreach ($tricks as $trickData) {
                $trick = new Trick();
                $trick->setUser($trickData['user']);
                $trick->setName($trickData['name'])
                ->setDescription($trickData['description'])
                ->setAddedAt(new \DateTimeImmutable())
                ->setUser($user)
                ->setCategory($category)
                ->setSlug($this->slugger->slug($trick->getName())->lower()->toString());
                
                foreach ($trickData["videos"] as $videoData) {
                    $video = new Video();
                    $video->setUrl($videoData);
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
                foreach ($trickData["illustrations"] as $illustrationData) {
                    $illustration = new Illustration();
                    $illustration->setPath($illustrationData);
                    $trick->addIllustration($illustration);

                    $manager->persist($illustration);
                }
                foreach ($trickData["comments"] ?? [] as $comment) {
                    $comment->setTrick($trick)
                    ->setPostedAt(new \DateTimeImmutable());
                    $manager->persist($comment);
                }
                $manager->persist($trick);
            }
        }
        $manager->flush();
    } 
}