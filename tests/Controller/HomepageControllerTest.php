<?php

namespace App\Tests\Controller;

use Generator;
use App\Entity\Trick;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * class HomepageControllerTest
 * @package App\Tests\Controller
 */
class HomepageControllerTest extends WebTestCase
{
    /* 
        Ce qu'on récupère dans nos arguments
        c'est ce qu'on passera dans notre tableau de yield
    */
    /**
     * @dataProvider provideUri
     * @param string $uri
     */
    public function testIsUp(string $uri)
    {
        // simule l'envoie d'une requête HTTP
        $client = static::createClient();
        // on souhaite accéder à la homepage
        $client->request(Request::METHOD_GET, $uri);
        // on test si la page s'affiche bien
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLoadMore()
    {
        $client = static::createClient();

        /*
            on récupère le router pour générer directement une url
            car plus tard l'url peut évolué on ne veut pas l'écrire en dure
        */
        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        // récupère un id en bdd (on récupère notre entityManager depuis notre client)
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        // on récupère un trick
        /** @var Trick $trick */
        $trick = $entityManager->getRepository(Trick::class)->findBy([]);

        $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("trick_load_more", ["page" => 2])
        );

        // on vérifie si on récupère bien un code 200
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }


    /* 
        Base d'Uri
        Instruction yield --> foreach qui fait un return
    */
    /**
     * @return Generator
     */
    public function provideUri(): Generator
    {
        yield ['/'];
    }
}