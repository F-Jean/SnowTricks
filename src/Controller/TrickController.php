<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\Comment;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Repository\TrickRepository;
use App\Repository\CommentRepository;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\AddIllustration;
use App\Service\EditIllustration;
use App\Service\DeleteTrick;
use App\Service\CreateComment;


class TrickController extends AbstractController
{
    private $slugger;
    private $trickRepository;

    public function __construct(TrickRepository $trickRepository, SluggerInterface $slugger, CommentRepository $commentRepository)
    {
        $this->slugger = $slugger;
        $this->trickRepository = $trickRepository;
        $this->commentRepository = $commentRepository;
    }

    /**
     * @Route("/trick/new", name="trick_add")
     */
    public function addTrick(Request $request, AddIllustration $illustrator)
    {
        $user = $this->getUser();
        $trick = new Trick();
        
        $form = $this->createForm(TrickType::class, $trick, ['validation_groups' => 'Default'])->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($trick->getName() !== null) {
                $trick->setSlug($this->slugger->slug($trick->getName())->lower()->toString())
                ->setAddedAt(new \DateTimeImmutable())
                ->setUser($user);
            }
            if ($form->isValid()) {
                if ($this->trickRepository->count(['slug' => $trick->getSlug()]) > 0) {
                    $form->get('name')->addError(new FormError('Cette figure existe déjà.'));
                } else {
                    // SERVICE AddIllustration
                    $illustrator->addIllustration($trick);
                    return $this->redirectToRoute('homepage', ['_fragment'=>'content-trick']);
                }
            }
        }
        
        return $this->render("trick/addTrick.html.twig", [
            'trickForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/trick/{slug}/edit", name="trick_edit")
     */
    public function editTrick(Trick $trick, Request $request, EditIllustration $editIllustrator)
    {
        $user = $this->getUser();
        $originalSlug = $trick->getSlug();

        $form = $this->createForm(TrickType::class, $trick,)->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($trick->getName() !== null) {
                $trick->setSlug($this->slugger->slug($trick->getName())->lower()->toString())
                ->setAddedAt(new \DateTimeImmutable())
                ->setUser($user);
            }

            $newSlug = $trick->getSlug();
            if ($originalSlug !== $newSlug) {
                if($this->trickRepository->count(['slug' => $newSlug]) > 0) {
                    $form->get('name')->addError(new FormError('Cette figure existe déjà !'));
                    $this->addFlash('error', 'Cette figure existe déjà !');
                }
            } 
            if ($form->isValid()) {
                // SERVICE EditIllustration
                $editIllustrator->editIllustration($trick);
                return $this->redirectToRoute('homepage', ['_fragment'=>'content-trick']);
            }
        }
        
        return $this->render("trick/editTrick.html.twig", [
            'trick' => $trick,
            'trickForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/trick/{slug}", name="trick_show")
     */
    public function show(Trick $trick, Request $request, CreateComment $createComment)
    {
        // get the actual user of the session
        $user = $this->getUser();

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            // SERVICE CreateComment
            $createComment($user, $comment, $trick);
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
    public function delete(Trick $trick, DeleteTrick $deleteTrick)
    { 
        // SERVICE DeleteTrick
        $deleteTrick->deleteTrick($trick);
        return $this->redirectToRoute('homepage');
    }
}
