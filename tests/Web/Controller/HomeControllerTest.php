<?php

namespace Tests\Spark\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HomeControllerTest extends WebTestCase
{

    
    public function testIndexReturnsResponse(): void
    {
        // Crée un client HTTP pour simuler des requêtes
        $client = static::createClient();

        // Effectue une requête GET sur la route racine
        $client->request('GET', '/');

        // Récupère la réponse
        $response = $client->getResponse();

        // Vérifie que la réponse est correcte
        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame(200, $response->getStatusCode(), 'La réponse doit avoir un code HTTP 200');
        $this->assertStringContainsString('Hello World !', $response->getContent());
    }
}
