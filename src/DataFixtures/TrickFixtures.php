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
use Symfony\Component\String\Slugger\SluggerInterface;


class TrickFixtures extends Fixture
{
    private $userEncoder;
    protected $slugger;

    public function __construct(UserPasswordEncoderInterface $userEncoder, SluggerInterface $slugger)
    {

        $this->userEncoder = $userEncoder;
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager)
    {
        $categories = array(
            "Grabs" => [
                [
                    "name" => "Nose Grab",
                    "description" => "La main avant grab le bout avant (nose) de la board. 
                    Levez votre jambe avant et étendez votre jambe arrière pour amener 
                    votre board vers votre main.</br>
                    Un grab consiste à attraper la planche avec la main pendant le saut. 
                    Le verbe anglais to grab signifie « attraper. »</br>
                    Il existe plusieurs types de grabs selon la position de la saisie et 
                    la main choisie pour l'effectuer.</br>
                    Un grab est d'autant plus réussi que la saisie est longue. De plus, 
                    le saut est d'autant plus esthétique que la saisie du snowboard 
                    est franche, ce qui permet au rideur d'accentuer la torsion de son 
                    corps grâce à la tension de sa main sur la planche. On dit alors 
                    que le grab est tweaké (le verbe anglais to tweak signifie « pincer » 
                    mais a également le sens de « peaufiner »).",
                    "illustrations" => [
                        "/public/uploads/trick_images/nose-grab_01.jpg",
                        "/public/uploads/trick_images/nose-grab_02.jpg",
                        "/public/uploads/trick_images/nose-grab_03.jpg"
                    ],
                    "videos" => [
                        "https://www.youtube.com/watch?v=nIS14rVlbyQ",
                        "https://www.youtube.com/watch?v=_Qq-YoXwNQY"
                    ],
                    "user" => [
                        "email" => "jean@symfony.com",
                        "username" => "fjean",
                        "password" => "Passwordf"
                    ],
                    "comments" => [
                        [
                            "content" => "ça à l'air dure par contre.",
                            "user"=> "bigJ"
                        ],
                        [
                            "content" => "En vrai facile",
                            "user"=> "fjean"
                        ], 
                        [
                            "content" => "j'ai déjà réussi celle-la",
                            "user"=> "tonio"
                        ],              
                    ]           
                ],
                [
                    "name" => "China air",
                    "description" => "La main avant grab la partie avant du snowboard. 
                    Les deux genoux sont pliés.",
                    "illustrations" => [
                        "/public/uploads/trick_images/china-air_01.jpg",
                        "/public/uploads/trick_images/china-air_02.jpg"
                    ],
                    "videos" => [
                        "https://www.youtube.com/watch?v=CA5bURVJ5zk"
                    ],
                    "user" => [
                        "email" => "loic@orange.com",
                        "username" => "lolo",
                        "password" => "Passwordl"
                    ],
                    "comments" => [
                        [
                            "content" => "Je me suis cassé le bras la dernière fois que j'ai tenté celle-là..",
                            "user"=> "claire"
                        ],
                        [
                            "content" => "Tranquille !",
                            "user"=> "lolo"
                        ],              
                    ]             
                ]
            ],
            "Rotations" => [
                [
                    "name" => "180",
                    "description" => "Un demi-tour, soit 180 degrés d'angle.</br>
                    Le principe est d'effectuer une rotation horizontale pendant le saut, 
                    puis d'attérir en position switch ou normal. La nomenclature se base 
                    sur le nombre de degrés de rotation effectués.</br>
                    Une rotation peut être frontside ou backside : une rotation frontside 
                    correspond à une rotation orientée vers la carre backside. Cela peut 
                    paraître incohérent mais l'origine étant que dans un halfpipe ou une 
                    rampe de skateboard, une rotation frontside se déclenche naturellement 
                    depuis une position frontside (i.e. l'appui se fait sur la carre 
                    frontside), et vice-versa. Ainsi pour un rider qui a une position 
                    regular (pied gauche devant), une rotation frontside se fait dans le 
                    sens inverse des aiguilles d'une montre.</br>
                    Une rotation peut être agrémentée d'un grab, ce qui rend le saut plus 
                    esthétique mais aussi plus difficile car la position tweakée a 
                    tendance à déséquilibrer le rideur et désaxer la rotation. De plus, 
                    le sens de la rotation a tendance à favoriser un sens de grab plutôt 
                    qu'un autre. Les rotations de plus de trois tours existent mais sont 
                    plus rares, d'abord parce que les modules assez gros pour lancer un 
                    tel saut sont rares, et ensuite parce que la vitesse de rotation est 
                    tellement élevée qu'un grab devient difficile, ce qui rend le saut 
                    considérablement moins esthétique.",
                    "illustrations" => [
                        "/public/uploads/trick_images/180_01.jpg",
                        "/public/uploads/trick_images/180_02.jpg"
                    ],
                    "videos" => [
                        "https://www.youtube.com/watch?v=Sj7CJH9YvAo",
                        "https://www.youtube.com/watch?v=JMS2PGAFMcE"
                    ],
                    "user" => [
                        "email" => "antoine@gmail.com",
                        "username" => "tonio",
                        "password" => "Passwordt"
                    ],
                    "comments" => [
                        [
                            "content" => "Je comprend pas ..",
                            "user"=> "bigJ"
                        ],             
                    ]
                ],
                [
                    "name" => "360",
                    "description" => "360, ou trois six pour un tour complet.</br>
                    Le principe est d'effectuer une rotation horizontale pendant le saut, puis d'attérir en position switch ou normal. La nomenclature 
                    se base sur le nombre de degrés de rotation effectués.</br>
                    Une rotation peut être frontside ou backside : une rotation 
                    frontside correspond à une rotation orientée vers la carre backside. 
                    Cela peut paraître incohérent mais l'origine étant que dans un 
                    halfpipe ou une rampe de skateboard, une rotation frontside se 
                    déclenche naturellement depuis une position frontside (i.e. l'appui 
                    se fait sur la carre frontside), et vice-versa. Ainsi pour un rider 
                    qui a une position regular (pied gauche devant), une rotation 
                    frontside se fait dans le sens inverse des aiguilles d'une montre.</br>
                    Une rotation peut être agrémentée d'un grab, ce qui rend le saut 
                    plus esthétique mais aussi plus difficile car la position tweakée a 
                    tendance à déséquilibrer le rideur et désaxer la rotation. De plus, 
                    le sens de la rotation a tendance à favoriser un sens de grab plutôt 
                    qu'un autre. Les rotations de plus de trois tours existent mais sont 
                    plus rares, d'abord parce que les modules assez gros pour lancer un 
                    tel saut sont rares, et ensuite parce que la vitesse de rotation est 
                    tellement élevée qu'un grab devient difficile, ce qui rend le saut 
                    considérablement moins esthétique.",
                    "illustrations" => [
                        "/public/uploads/trick_images/360_01.jpg",
                        "/public/uploads/trick_images/360_02.jpg"
                    ],
                    "videos" => [
                        "https://www.youtube.com/watch?v=GS9MMT_bNn8",
                        "https://www.youtube.com/watch?v=grXpguVaqls"
                    ],
                    "user" => [
                        "email" => "claire@symfony.com",
                        "username" => "claire",
                        "password" => "Passwordc"
                    ],
                    "comments" => [
                        [
                            "content" => "Mouaih pas mal !!",
                            "user"=> "claire"
                        ],
                        [
                            "content" => "Facile !",
                            "user"=> "fjean"
                        ], 
                        [
                            "content" => "Trop cool !",
                            "user"=> "lolo"
                        ],              
                    ]             
                ]
            ],
            "Flips" => [
                [
                    "name" => "Back flip",
                    "description" => "Rotation verticale en arrière lors d'un saut. Il 
                    est possible de faire plusieurs flips à la suite, et d'ajouter un 
                    grab à la rotation.</br>
                    Les flips agrémentés d'une vrille existent aussi (Mac Twist, Hakon 
                    Flip...), mais de manière beaucoup plus rare, et se confondent 
                    souvent avec certaines rotations horizontales désaxées.</br> 
                    Néanmoins, en dépit de la difficulté technique relative d'une telle 
                    figure, le danger de retomber sur la tête ou la nuque est réel et 
                    conduit certaines stations de ski à interdire de telles figures dans 
                    ses snowparks.",
                    "illustrations" => [
                        "/public/uploads/trick_images/backflip_01.jpg",
                        "/public/uploads/trick_images/backflip_02.jpg",
                        "/public/uploads/trick_images/backflip_03.jpg",
                        "/public/uploads/trick_images/backflip_04.jpg"
                    ],
                    "videos" => [
                        "https://www.youtube.com/watch?v=Sj7CJH9YvAo",
                        "https://www.youtube.com/watch?v=JMS2PGAFMcE"
                    ],
                    "user" => [
                        "email" => "marie@symfony.com",
                        "username" => "marie",
                        "password" => "Passwordm"
                    ],
                    "comments" => [
                        [
                            "content" => "Dites moi ce que vous pensez de celle-là.",
                            "user"=> "marie"
                        ],
                        [
                            "content" => "Pas mal !",
                            "user"=> "fjean"
                        ], 
                        [
                            "content" => "Trop cool !",
                            "user"=> "tonio"
                        ],              
                    ]            
                ]               
            ],
            "Rotations désaxées" => [
                [
                    "name" => "McTwist",
                    "description" => "Un backside 540 avant-flip, exécuté dans un 
                    half-pipe, un quarterpipe ou un obstacle similaire.",
                    "illustrations" => [
                        "/public/uploads/trick_images/McTwist_01.jpg",
                        "/public/uploads/trick_images/McTwist_02.jpg"
                    ],
                    "videos" => [
                        "https://www.youtube.com/watch?v=k-CoAquRSwY"
                    ],
                    "user" => [
                        "email" => "john@symfony.com",
                        "username" => "bigJ",
                        "password" => "Passwordj"
                    ],
                    "comments" => [
                        [
                            "content" => "Pas sûr que je l'essai celle-là !!!",
                            "user"=> "bigJ"
                        ],
                        [
                            "content" => "Les yeux fermés, easy.",
                            "user"=> "fjean"
                        ]             
                    ]             
                ],
                [
                    "name" => "Misty",
                    "description" => "Le Misty Flip est une rotation arrière hors axe 
                    540.</br>
                    Une rotation désaxée est une rotation initialement horizontale mais 
                    lancée avec un mouvement des épaules particulier qui désaxe la 
                    rotation.</br>
                    Certaines de ces rotations, bien qu'initialement horizontales, font 
                    passer la tête en bas.</br>
                    Bien que certaines de ces rotations soient plus faciles à faire sur 
                    un certain nombre de tours (ou de demi-tours) que d'autres, il est 
                    en théorie possible de d'attérir n'importe quelle rotation désaxée 
                    avec n'importe quel nombre de tours, en jouant sur la quantité de 
                    désaxage afin de se retrouver à la position verticale au moment 
                    voulu.</br>
                    Il est également possible d'agrémenter une rotation désaxée par un 
                    grab.)",
                    "illustrations" => [
                        "/public/uploads/trick_images/misty.jpg"
                    ],
                    "videos" => [
                        "https://www.youtube.com/watch?v=hPuVJkw1MmI",
                        "https://www.youtube.com/watch?v=FMHiSF0rHF8"
                    ],
                    "user" => [
                        "email" => "antoine@gmail.com",
                        "username" => "tonio",
                        "password" => "Passwordt"
                    ],
                    "comments" => [
                        [
                            "content" => "J'aime pas la faire celle-la.",
                            "user"=> "tonio"
                        ],
                        [
                            "content" => "Moui elle est dure à rentrer.",
                            "user"=> "fjean"
                        ], 
                        [
                            "content" => "J'avoue !",
                            "user"=> "lolo"
                        ],              
                    ]              
                ]              
            ],
            "Slides" => [
                [
                    "name" => "Boardslide",
                    "description" => "Une glissade effectuée où le pied fort du 
                    snowboarder passe au-dessus du rail à l'approche, avec son snowboard 
                    se déplaçant perpendiculairement le long du rail ou d'un autre 
                    obstacle. Lors de l'exécution d'un boardslide frontside, le 
                    snowboarder fait face à la montée. Lors de l'exécution d'un 
                    backside boardslide, un snowboarder fait face à la descente. C'est 
                    souvent déroutant pour les nouveaux riders qui apprennent le trick 
                    car avec un boardslide frontside vous reculez et avec un boardslide 
                    backside vous avancez.",
                    "illustrations" => [
                        "/public/uploads/trick_images/slide_01.jpg",
                        "/public/uploads/trick_images/slide_02.jpg",
                        "/public/uploads/trick_images/slide_03.jpg"
                    ],
                    "videos" => [
                        "https://www.youtube.com/watch?v=R3OG9rNDIcs",
                        "https://www.youtube.com/watch?v=hdqAhRO7bIw",
                        "https://www.youtube.com/watch?v=gO5GLk7oQhU"
                    ],
                    "user" => [
                        "email" => "marie@symfony.com",
                        "username" => "marie",
                        "password" => "Passwordm"
                    ],
                    "comments" => [
                        [
                            "content" => "J'aime bien les slides aussi !",
                            "user"=> "marie"
                        ],
                        [
                            "content" => "Au début on aime pas forcément ehehe!",
                            "user"=> "bigJ"
                        ],
                        [
                            "content" => "Bah ça viendra tkt !",
                            "user"=> "claire"
                        ],
                        [
                            "content" => "Mais oui, mais oui !",
                            "user"=> "bigJ"
                        ],             
                    ]               
                ]              
            ],
            "One foot tricks" => [
                [
                    "name" => "One-foot Indy",
                    "description" => "Lors du saut la main arrière grab la partie arrière 
                    du snowboard ou le pied arrière a été détaché. La jambe arrière est 
                    écarté vers l'arrière du snowboard avant de revenir en place avant 
                    la fin du saut en restant toujours détaché.",
                    "illustrations" => [
                        "/public/uploads/trick_images/one-foot-indy_01.jpg",
                        "/public/uploads/trick_images/one-foot-indy_02.jpg"
                    ],
                    "videos" => [
                        "https://www.youtube.com/watch?v=7WJb_igyZ5w",
                        "https://www.youtube.com/watch?v=LWUfrwCofuA&t=8s"
                    ],
                    "user" => [
                        "email" => "marie@symfony.com",
                        "username" => "marie",
                        "password" => "Passwordm"
                    ],
                    "comments" => [
                        [
                            "content" => "Même pas en rêve !",
                            "user"=> "fjean"
                        ],
                        [
                            "content" => "Juste une question d'entrainement, comme d'hab",
                            "user"=> "marie"
                        ],            
                    ]              
                ]              
            ],
            "Old school" => [
                [
                    "name" => "Japan air",
                    "description" => "La main avant grab la carre front au niveau de la 
                    fix avant, les genoux sont pliés, et la board est tirée vers le haut.</br>
                    Un grab consiste à attraper la planche avec la main pendant le saut. 
                    Le verbe anglais to grab signifie « attraper. »</br>
                    Il existe plusieurs types de grabs selon la position de la saisie et 
                    la main choisie pour l'effectuer.</br>
                    Un grab est d'autant plus réussi que la saisie est longue. De plus, 
                    le saut est d'autant plus esthétique que la saisie du snowboard est 
                    franche, ce qui permet au rideur d'accentuer la torsion de son corps 
                    grâce à la tension de sa main sur la planche. On dit alors que le 
                    grab est tweaké (le verbe anglais to tweak signifie « pincer » mais 
                    a également le sens de « peaufiner »).",
                    "illustrations" => [
                        "path" => [
                            "/public/uploads/trick_images/japan-air_01.jpg",
                            "/public/uploads/trick_images/japan-air_02.jpg"
                        ]
                    ],
                    "videos" => [
                        "url" => ["https://www.youtube.com/watch?v=I7N45iRPrhw"],
                    ],
                    "user" => [
                        "email" => "jean@symfony.com",
                        "username" => "fjean",
                        "password" => "Passwordf"
                    ],
                    "comments" => [
                        [
                            "content" => "Les jump, y'a quand même rien de mieux je trouve",
                            "user"=> "fjean"
                        ],
                        [
                            "content" => "Pour bien s'éclater oui c'est sûr !!!!",
                            "user"=> "bigJ"
                        ],             
                    ]               
                ]         
            ],
        );

        foreach ($categories as $categoryName => $tricks) {
            $category = new Category();
            $category->setName($categoryName['name']);

            $manager->persist($category);

            foreach ($tricks as $trickData) {
                $trick = new Trick();
                $user = new User();
                $user->setUserName($trickData['user']['username'])
                ->setEmail($trickData['user']['email'])
                ->setPassword($this->userEncoder->encodePassword($user, $trickData['user']['password']));

                $manager->persist($user);

                $trick->setName($trickData['name'])
                ->setDescription($trickData['description'])
                ->setAddedAt(new \DateTimeImmutable())
                ->setUser($user)
                ->setCategory($category)
                ->setSlug($this->slugger->slug($trick->getName()));

                foreach ($trick["videos"] as $video) {
                    $video = new Video();
                    $video->setUrl($video['url']);
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
                foreach ($trick["illustrations"] as $illustration) {
                    $illustration = new Illustration();
                    $illustration->setPath($illustration['path']);
                    $trick->addIllustration($illustration);

                    $manager->persist($illustration);
                }
                foreach ($trick["comments"] as $comment) {
                    $comment = new Comment();
                    $comment->setUser($comment['user']);
                    $comment->setTrick($trick)
                    ->setPostedAt(new \DateTimeImmutable())
                    ->setContent($comment['content']);

                    $manager->persist($comment);
                }
                $manager->persist($trick);
            }
        }
        $manager->flush();
    } 
}

        // OLD ONES
        /*
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
                ->setCategory($category)
                ->setSlug($this->slugger->slug($trick->getName()));
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
                    // manually setting the url for the moment (copy of the user's one will be sending)
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
        */