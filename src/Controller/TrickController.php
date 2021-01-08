<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\Comment;
use App\Entity\Illustration;
use App\Form\TrickType;
use App\Form\CommentType;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TrickController extends AbstractController
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/trick/new", name="trick_add")
     */
    public function addTrick(Request $request, EntityManagerInterface $manager)
    {
        $user = $this->getUser();

        $trick = new Trick();

        // add some ilustrations to test
        $illustration1 = new Illustration();
        $illustration1->setPath('https://unsplash.com/photos/osE_JD9CG6A');
        $trick->getillustrations()->add($illustration1);
        $illustration2 = new Illustration();
        $illustration2->setPath('https://unsplash.com/photos/wN4D-mVR7fE');
        $trick->getIllustrations()->add($illustration2);
        
        $form = $this->createForm(TrickType::class, $trick,)->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $trick->setAddedAt(new \DateTimeImmutable())
            ->setUser($user);
            $manager->persist($trick);
            $manager->flush();

            return $this->redirectToRoute('trick_show', ['id' => $trick->getId()]);
        }

        return new Response($this->twig->render("trick/addTrick.html.twig", [
            'trickForm' => $form->createView()
        ]));
    }

    /**
     * @Route("/trick/{id}", name="trick_show")
     */
    public function show(Trick $trick, Request $request, EntityManagerInterface $manager)
    {
        // get the actual user of the session
        $user = $this->getUser();

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $comment->setPostedAt(new \DateTimeImmutable())
                    ->setTrick($trick)
                    ->setUser($user);
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('trick_show', ['id' => $trick->getId()]);
        }

        return new Response($this->twig->render("trick/show.html.twig", [
            'trick' => $trick,
            'commentForm' => $form->createView()
        ]));
    }
}
