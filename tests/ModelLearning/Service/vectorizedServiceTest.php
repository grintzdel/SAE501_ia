<?php

namespace Tests\Spark\ModelLearning\Service;

use PHPUnit\Framework\TestCase;
use Spark\ModelLearning\DatasetLoader;
use Spark\ModelLearning\Service\vectorizedService;

class vectorizedServiceTest extends TestCase
{
    public function testVectorized(): void
    {
        $loader = new DatasetLoader();
        $testingDataSet = $loader->loadDataset(__DIR__ . '/../../image/training');
        $vectorizer = new vectorizedService();
        $vectorizer->vectorizedImage($testingDataSet);
    }
}
