<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TrickRepository;
use Twig\Environment;


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
}
