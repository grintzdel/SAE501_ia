<?php

namespace Tests\Spark\ModelLearning\Model;

use PHPUnit\Framework\TestCase;
use Rubix\ML\Classifiers\MultilayerPerceptron;
use Spark\ModelLearning\Model\MLP;

class MLPTest extends TestCase
{
    public function testCreateModelMLP(): void
    {
        $model = (new MLP())->createModelMLP();
        $this->assertInstanceOf(MultilayerPerceptron::class, $model);
    }
}
