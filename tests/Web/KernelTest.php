<?php

namespace Tests\Spark\Web;

use PHPUnit\Framework\TestCase;
use Spark\Web\Kernel;

class KernelTest extends TestCase
{
    public function testConstruct(): void
    {
        $kernel = new Kernel("test", true);
        $this->assertInstanceOf(Kernel::class, $kernel);
        $this->assertTrue($kernel->isDebug());
    }
}
