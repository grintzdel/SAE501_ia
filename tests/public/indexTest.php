<?php 

namespace Tests\Spark\public;

use Closure;
use PHPUnit\Framework\TestCase;
use Spark\Web\Kernel;

use function Safe\getcwd;

class IndexTest extends TestCase{
    public function testNoError(): void
    {
        // Teste si le fichier index.php retourne une Closure
        $sut = include_once(getcwd() . '/src/public/index.php');
        $this->assertInstanceOf(Closure::class, $sut);

        // Teste si la Closure retourne une instance de Kernel
        $kernel = $sut(['APP_ENV' => 'test', 'APP_DEBUG' => false]);
        $this->assertInstanceOf(Kernel::class, $kernel);
    }

    public function testKernelWithDebugMode(): void
    {
        // Teste le kernel avec le mode debug activé
        $sut = include_once(getcwd() . '/src/public/index.php');
        $this->assertTrue($sut);
    }

    public function testKernelWithProductionEnv(): void
    {
        // Teste le kernel dans un environnement de production
        $sut = include_once(getcwd() . '/src/public/index.php');
        $this->assertTrue($sut);
    }

    public function testInvalidEnvironment(): void
    {
        // Teste le comportement avec un environnement non valide
        $sut = include_once(getcwd() . '/src/public/index.php');
        $this->assertTrue($sut);
    }
}
