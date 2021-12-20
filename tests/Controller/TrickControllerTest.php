<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Entity\Trick;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class TrickControllerTest
 * @package App\Tests\Controller
 */
class TrickControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function trick_should_be_displayed()
    {
        $client = static::createClient();

        /*
            on récupère le router pour générer directement une url
            car plus tard l'url peut évolué donc on ne veut pas l'écrire en dure
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

    /**
     * @test
     */
    public function add_trick_page_should_be_displayed()
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        /** @var Trick $trick */
        $trick = $entityManager->getRepository(Trick::class)->findOneBy([]);

        $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("trick_add")
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function edit_trick_should_be_displayed()
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        /** @var Trick $trick */
        $trick = $entityManager->getRepository(Trick::class)->findOneBy([]);

        $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("trick_edit", ["slug" => $trick->getSlug()])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function comment_is_submitted()
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        /** @var Trick $trick */
        $trick = $entityManager->getRepository(Trick::class)->findOneBy([]);
        $user = $entityManager->getRepository(User::class)->findOneBy([]);
        $client->loginUser($user);
        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("trick_show", ["slug" => $trick->getSlug()])
        );

        $form = $crawler->filter('form[name=comment]')->form([
            'comment[content]' => 'new comment',
        ]);

        $client->submit($form);

        // if everything worked we should have a redirection 302
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();

        $this->assertSelectorTextContains('html', 'new comment');
    }

    /**
     * @test
     */
    public function load_more_comments()
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        /** @var Trick $trick */
        $trick = $entityManager->getRepository(Trick::class)->findBy([]);

        $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate("load_comments", ["id" => $trick, "page" => 2])
        );

        // on vérifie si on récupère bien un code 200
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}