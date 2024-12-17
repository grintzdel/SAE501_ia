<?php

namespace Spark\ModelLearning;

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Estimator;
use Spark\ModelLearning\Fabric\ModelFabric;

class ModelTrainer
{
    private Estimator $estimator;

    public function __construct(string $algorithm = 'tree')
    {
        $this->estimator = (new ModelFabric())->createModel($algorithm);
    }

    public function train(Labeled $trainingDataset): void
    {
        $this->estimator->train($trainingDataset);
    }

    public function saveModel(string $filePath): void
    {
        file_put_contents($filePath, serialize($this->estimator));
    }

    public function getEstimator(): Estimator
    {
        return $this->estimator;
    }
}
