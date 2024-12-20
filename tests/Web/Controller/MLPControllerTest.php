<?php
namespace Tests\Spark\Web\Controller;

use Spark\Web\Controller\MlpController;
use Spark\Web\Service\MlpService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use PHPUnit\Framework\MockObject\MockObject;

class MlpControllerTest extends WebTestCase
{
    /**
     * @var MlpService|MockObject
     */
    private $modelTestService;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer un mock pour MlpService
        $this->modelTestService = $this->createMock(MlpService::class);
    }

    public function testMlpControllerWithValidImage()
    {
        // Créer un client pour effectuer des requêtes HTTP
        $client = static::createClient();

        // Simuler un fichier image valide
        $file = new UploadedFile(
            __DIR__ . '/imageTest/test_image.png', // Remplacez par le chemin de votre image de test
            'test_image.png',
            'image/png',
            null,
            true
        );

        // Configurer le mock du service pour renvoyer une prédiction
        $this->modelTestService
            ->method('testImage')
            ->willReturn(0);  // Simulation d'une prédiction du modèle, ici "5"

        // Simuler la requête POST
        $crawler = $client->request('POST', '/mlp', [], ['image' => $file]);

        

        // Vérifier que le flash message de succès est affiché
        $this->assertStringContainsString('Le modèle a prédit le chiffre : 0', $client->getResponse()->getContent());
    }

    public function testMlpControllerWithInvalidImage()
    {
        // Créer un client pour effectuer des requêtes HTTP
        $client = static::createClient();

        // Simuler un fichier non valide (ex : un fichier texte)
        $file = new UploadedFile(
            __DIR__ . '/imageTest/test_invalid.txt', // Remplacez par le chemin d'un fichier invalide
            'test_invalid.txt',
            'text/plain',
            null,
            true
        );

        // Simuler la requête POST avec un fichier invalide
        $crawler = $client->request('POST', '/mlp', [], ['image' => $file]);

        // Vérifier que le code de réponse est 302 (redirection)
        $this->assertResponseRedirects();

        // Vérifier que le flash message d'erreur est affiché
        $this->assertStringContainsString('Redirecting to /mlp', $client->getResponse()->getContent());
    }

    public function testMlpControllerWithException()
    {
        // Créer un client pour effectuer des requêtes HTTP
        $client = static::createClient();

        // Simuler un fichier image valide
        $file = new UploadedFile(
            __DIR__ . '/imageTest/test_image.png', // Remplacez par le chemin de votre image de test
            'test_image.png',
            'image/png',
            null,
            true
        );

        // Configurer le mock du service pour lancer une exception
        $this->modelTestService
            ->method('testImage')
            ->willThrowException(new \Exception("Erreur lors de la prédiction"));

        // Simuler la requête POST
        $crawler = $client->request('POST', '/mlp', [], ['image' => $file]);

        // Vérifier que le code de réponse est 302 (redirection)
        

        // Vérifier que le flash message d'erreur est affiché
        $this->assertStringContainsString('Envoyez une image pour tester le modèle de prédiction', $client->getResponse()->getContent());
    }
}
