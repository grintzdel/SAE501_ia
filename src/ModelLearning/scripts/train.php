<?php

use Spark\ModelLearning\DatasetLoader;
use Spark\ModelLearning\ModelTrainer;

require_once __DIR__ . '/../../../vendor/autoload.php';

$algorithm = $argv[1] ?? 'tree';

$loader = new DatasetLoader();
$trainer = new ModelTrainer($algorithm);

echo "Loading training dataset...\n";
$trainingDataset = $loader->loadDataset(__DIR__ . '/../image/training');
echo "Training dataset loaded.\n";

echo "Training the model...\n";
$trainer->train($trainingDataset);
echo "Model trained.\n";

$modelsDir = __DIR__ . '/../../public';
if (!is_dir($modelsDir)) {
    mkdir($modelsDir, 0777, true);
}

// Save the trained model
$trainer->saveModel($modelsDir . '/model_' . $algorithm . '.rbx');
