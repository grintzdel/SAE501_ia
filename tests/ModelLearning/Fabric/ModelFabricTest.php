<?php

namespace Tests\Spark\ModelLearning\Fabric;

use PHPUnit\Framework\TestCase;
use Spark\ModelLearning\Exception\NoModelException;
use Spark\ModelLearning\Fabric\ModelFabric;
use Spark\ModelLearning\Model\MLP;
use Spark\ModelLearning\Model\Tree;

class ModelFabricTest extends TestCase
{
    public function testCreateModelMLPWithFabric(): void
    {
        $fabric = new ModelFabric();
        $model = $fabric->createModel('mlp');
        $this->assertInstanceOf(MLP::class, $model);
    }

    public function testCreateModelTreeWithFabric(): void
    {
        $fabric = new ModelFabric();
        $model = $fabric->createModel('tree');
        $this->assertInstanceOf(Tree::class, $model);
    }

    public function testExceptionFabric(): void
    {
        $this->expectException(NoModelException::class);
        $this->expectExceptionMessage("Bad model name, please enter 'mlp' or 'tree'");
        $fabric = new ModelFabric();
        $model = $fabric->createModel("noModel");
    }
}
