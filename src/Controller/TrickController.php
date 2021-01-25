<?php

namespace App\Controller;

use App\Entity\Trick;
use Twig\Environment;
use App\Entity\Comment;
use App\Form\TrickType;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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
    public function addTrick(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger)
    {
        $user = $this->getUser();
        $trick = new Trick();
        
        $form = $this->createForm(TrickType::class, $trick,)->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $trick->setAddedAt(new \DateTimeImmutable())
            ->setUser($user);

            foreach ($trick->getIllustrations() as $illustration)
            {
                $uploadedFile = $illustration->getFile();
                $destination = $this->getParameter('kernel.project_dir').'/public/uploads/trick_images';

                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();

                $uploadedFile->move(
                    $destination,
                    $newFilename
                );

                $illustration->setPath($newFilename);
            }

            $manager->persist($trick);
            $manager->flush();

            return $this->redirectToRoute('trick_show', ['id' => $trick->getId()]);
        }

        return new Response($this->twig->render("trick/addTrick.html.twig", [
            'trickForm' => $form->createView(),
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
