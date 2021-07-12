<?php

namespace App\Controller;

use Twig\Environment;
use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomepageController extends AbstractController
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
     * @Route("/", name="homepage")
     */
    public function index(TrickRepository $trickRepository)
    {
        return new Response($this->twig->render("homepage/index.html.twig", [
            'tricks' => $trickRepository->getTricks(1, 5),
        ]));
    }

    /**
     * @Route("/load_more/{page}", name="trick_load_more", requirements={"page": "\d+"})
     */
    public function loadMore(TrickRepository $trickRepository, int $page)
    {
        return new Response($this->twig->render("homepage/trick.html.twig", [
            'tricks' => $trickRepository->getTricks($page, 5),
        ]));
    }
}
