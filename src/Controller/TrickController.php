<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\Comment;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\HandleTrick;


class TrickController extends AbstractController
{
    private $slugger;
    private $commentRepository;

    public function __construct(SluggerInterface $slugger, CommentRepository $commentRepository)
    {
        $this->slugger = $slugger;
        $this->commentRepository = $commentRepository;
    }

    /**
     * @Route("/trick/new", name="trick_add")
     */
    public function addTrick(Request $request, HandleTrick $handleTrick)
    {
        $user = $this->getUser();
        $trick = new Trick();
        $trick->setUser($user);
        
        $form = $this->createForm(TrickType::class, $trick, ['validation_groups' => ['Default', 'add']])
        ->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setSlug($this->slugger->slug($trick->getName())->lower()->toString());

            $handleTrick->addTrick($trick);
            return $this->redirectToRoute('homepage', ['_fragment'=>'content-trick']);
        }
        
        return $this->render("trick/addTrick.html.twig", [
            'trickForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/trick/{slug}/edit", name="trick_edit")
     */
    public function editTrick(Trick $trick, Request $request, HandleTrick $handleTrick)
    {
        $form = $this->createForm(TrickType::class, $trick,)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setSlug($this->slugger->slug($trick->getName())->lower()->toString());

            $handleTrick->editTrick($trick, $form);
            return $this->redirectToRoute('homepage', ['_fragment'=>'content-trick']);
        }
        
        return $this->render("trick/editTrick.html.twig", [
            'trick' => $trick,
            'trickForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/trick/{slug}", name="trick_show")
     */
    public function show(Trick $trick, Request $request, HandleTrick $handleTrick)
    {
        // get the actual user of the session
        $user = $this->getUser();

        $comment = new Comment();
        $comment->setUser($user);
        $form = $this->createForm(CommentType::class, $comment)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $handleTrick->handleComment($user, $comment, $trick);
            return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
        }

        return $this->render("trick/show.html.twig", [
            'trick' => $trick,
            'commentForm' => $form->createView(),
            'comments' => $this->commentRepository->getComments(1, 3, $trick),
        ]);
    }

    /**
     * @Route("/load_comments/{id}/{page}", name="load_comments", requirements={"page": "\d+"})
     */
    public function loadComments(Trick $trick, int $page)
    {
        return $this->render("trick/comment.html.twig", [
            'comments' => $this->commentRepository->getComments($page, 3, $trick),
        ]);
    }

    /**
     * @Route("/trick/{slug}/delete", name="trick_delete")
     */
    public function delete(Trick $trick, HandleTrick $handleTrick)
    { 
        $handleTrick->deleteTrick($trick);
        return $this->redirectToRoute('homepage');
    }
}
