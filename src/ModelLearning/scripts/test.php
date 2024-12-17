<?php

use Spark\ModelLearning\DatasetLoader;
use Spark\ModelLearning\ModelTester;
use Spark\ModelLearning\Service\vectorizedService;

require_once __DIR__ . '/../../../vendor/autoload.php';

$algorithm = $argv[1] ?? 'tree';

$loader = new DatasetLoader();
$tester = new ModelTester($algorithm);
$vectorizer = new vectorizedService();

echo "Loading testing dataset...\n";
$testingDataset = $loader->loadDataset(__DIR__ . '/../image/testing');
$vectorizer->vectorizedImage($testingDataset);
echo "Testing dataset loaded.\n";

$tester->loadModel(__DIR__ . '/../../public/model_' . $algorithm . '.rbx');

echo "Testing the model...\n";
$results = $tester->test($testingDataset);
$accuracy = $results['accuracy'];
$confusionMatrix = $results['confusion_matrix'];

echo 'Accuracy: ' . ($accuracy * 100) . "%\n";
echo "Confusion Matrix:\n";
foreach ($confusionMatrix as $actual => $predictions) {
    echo $actual . ': ' . implode(', ', $predictions) . "\n";
}
