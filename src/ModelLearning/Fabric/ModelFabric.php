<?php

namespace Spark\ModelLearning\Fabric;

use Rubix\ML\Estimator;
use Spark\ModelLearning\Exception\NoModelException;
use Spark\ModelLearning\Model\MLP;
use Spark\ModelLearning\Model\Tree;

class ModelFabric
{
    public function createModel(string $model): Estimator
    {
        switch ($model) {
            case 'mlp':
                return new MLP();
            case 'tree':
                return new Tree();
            default:
                throw new NoModelException("Bad model name, please enter 'mlp' or 'tree'");
        }
    }
}
