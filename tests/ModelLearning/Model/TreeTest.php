<?php

namespace Tests\Spark\ModelLearning\Model;

use PHPUnit\Framework\TestCase;
use Rubix\ML\Classifiers\RandomForest;
use Spark\ModelLearning\Model\Tree;

class treeTest extends TestCase
{
    public function testCreateModelTree(): void
    {
        $model = (new Tree())->createModelTree();
        $this->assertInstanceOf(RandomForest::class, $model);
    }
}
