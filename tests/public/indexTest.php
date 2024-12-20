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
       var_dump($sut);
        $this->assertTrue($sut);

        $kernel = $sut(['APP_ENV' => 'dev', 'APP_DEBUG' => true]);
        $this->assertInstanceOf(Kernel::class, $kernel);
        $this->assertTrue(method_exists($kernel, 'isDebugMode') && $kernel->isDebugMode());
    }

    public function testKernelWithProductionEnv(): void
    {
        // Teste le kernel dans un environnement de production
        $sut = include_once(getcwd() . '/src/public/index.php');
        $this->assertInstanceOf(Closure::class, $sut);

        $kernel = $sut(['APP_ENV' => 'prod', 'APP_DEBUG' => false]);
        $this->assertInstanceOf(Kernel::class, $kernel);
        $this->assertTrue(method_exists($kernel, 'getEnvironment') && $kernel->getEnvironment() === 'prod');
    }

    public function testInvalidEnvironment(): void
    {
        // Teste le comportement avec un environnement non valide
        $sut = include_once(getcwd() . '/src/public/index.php');
        $this->assertInstanceOf(Closure::class, $sut);

        $this->expectException(\InvalidArgumentException::class);
        $sut(['APP_ENV' => 'invalid_env', 'APP_DEBUG' => false]);
    }
}
