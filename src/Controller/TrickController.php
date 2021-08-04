<?php

namespace App\Controller;

use App\Entity\Trick;
use Twig\Environment;
use App\Entity\Comment;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Repository\CommentRepository;
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
        $trick->setSlug($slugger->slug($trick->getName())->lower()->toString());
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

            /* add a success flash message */
            $this->addFlash('success', 'La figure a bien été ajouté !');

            return $this->redirectToRoute('homepage', ['_fragment'=>'content-trick']);
        }
        
        return new Response($this->twig->render("trick/addTrick.html.twig", [
            'trickForm' => $form->createView(),
        ]));
    }

    /**
     * @Route("/trick/{slug}/edit", name="trick_edit")
     */
    public function editTrick(Trick $trick, Request $request, EntityManagerInterface $manager, SluggerInterface $slugger)
    {
        $user = $this->getUser();
        
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

            /* add a success flash message */
            $this->addFlash('success', 'La figure a bien été modifié !');

            return $this->redirectToRoute('homepage', ['_fragment'=>'content-trick']);
        }
        
        return new Response($this->twig->render("trick/editTrick.html.twig", [
            'trick' => $trick,
            'trickForm' => $form->createView(),
        ]));
    }

    /**
     * @Route("/trick/{slug}", name="trick_show")
     */
    public function show(Trick $trick, Request $request, EntityManagerInterface $manager, CommentRepository $commentRepository)
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

            return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
        }

        return new Response($this->twig->render("trick/show.html.twig", [
            'trick' => $trick,
            'commentForm' => $form->createView(),
            'comments' => $commentRepository->getComments(1, 5),
        ]));
    }

    /**
     * @Route("/load_comments/{page}", name="load_comments", requirements={"page": "\d+"})
     */
    public function loadComments(CommentRepository $commentRepository, int $page)
    {
        return new Response($this->twig->render("trick/comment.html.twig", [
            'comments' => $commentRepository->getComments($page, 5),
        ]));
    }

    /**
     * @Route("/trick/{slug}/delete", name="trick_delete")
     */
    public function delete(Trick $trick)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($trick);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }
}
