<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomepageController extends AbstractController
{
    private $trickRepository;

    public function __construct(TrickRepository $trickRepository)
    {
        $this->trickRepository = $trickRepository;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render("homepage/index.html.twig", [
            'tricks' => $this->trickRepository->getTricks(1, 5),
        ]);
    }

    /**
     * @Route("/load_more/{page}", name="trick_load_more", requirements={"page": "\d+"})
     */
    public function loadMore(int $page)
    {
        return $this->render("homepage/trick.html.twig", [
            'tricks' => $this->trickRepository->getTricks($page, 5),
        ]);
    }
}
