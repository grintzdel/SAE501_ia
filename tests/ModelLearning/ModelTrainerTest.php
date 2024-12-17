<?php

namespace Tests\Spark\ModelLearning;

use PHPUnit\Framework\TestCase;
use Spark\ModelLearning\Model\MLP;
use Spark\ModelLearning\ModelTrainer;

class ModelTrainerTest extends TestCase
{
    public function testConstruct(): void
    {
        $model = new ModelTrainer("mlp");
        $this->assertInstanceOf(MLP::class, $model->getEstimator());
        //$this->assertInstanceOf(MultilayerPerceptron::class, $model->getModel());
    }
}
