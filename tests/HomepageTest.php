<?php

namespace App\Tests;

use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * class HomepageTest
 * @package App\Tests
 */
class HomepageTest extends WebTestCase
{
    /* 
        Ce qu'on récupère dans nos arguments
        c'est ce qu'on passera dans notre tableau de yield
    */
    /**
     * @dataProvider provideUri
     * @param string $uri
     */
    public function test(string $uri)
    {
        // simule l'envoie d'une requête HTTP
        $client = static::createClient();
        // on souhaite accéder à la homepage
        $client->request(Request::METHOD_GET, $uri);
        // on test si la page s'affiche bien
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