<?php

namespace App\Tests;

use App\Entity\Trick;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class DisplayTrickTest
 * @package App\Tests
 */
class DisplayTrickTest extends WebTestCase
{
    public function test()
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
        $trick = $entityManager->getRepository(Trick::class)->findOneBy([]);

        $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("trick_show", ["slug" => $trick->getSlug()])
        );

        // on vérifie si on récupère bien un code 200
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}