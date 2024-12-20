<?php

use Rubix\ML\Datasets\Labeled;
use Spark\ModelLearning\DatasetLoader;
use Spark\ModelLearning\ModelTrainer;

require_once __DIR__ . '/../../../vendor/autoload.php';

$algorithm = $argv[1] ?? 'tree';
$singleImagePath = $argv[2] ?? null;

$loader = new DatasetLoader();
$trainer = new ModelTrainer($algorithm);

echo "Loading training dataset...\n";
$trainingDataset = $loader->loadDataset(__DIR__ . '/../image/training');
echo "Training dataset loaded.\n";

if ($singleImagePath && file_exists($singleImagePath)) {
    echo "Loading single image...\n";
    $image = imagecreatefrompng($singleImagePath);
    imagefilter($image, IMG_FILTER_GRAYSCALE);

    $width = imagesx($image);
    $height = imagesy($image);

    $pixels = [];
    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            $colorIndex = imagecolorat($image, $x, $y);
            $color = imagecolorsforindex($image, $colorIndex);
            $pixels[] = $color['red'] / 255;
        }
    }

    $singleImageDataset = Labeled::build([$pixels], ['single_image']);
    $trainingDataset = $trainingDataset->merge($singleImageDataset);
    imagedestroy($image);
    echo "Single image loaded.\n";
}

echo "Training the model...\n";
$trainer->train($trainingDataset);
echo "Model trained.\n";

$modelsDir = __DIR__ . '/../../public';
if (!is_dir($modelsDir)) {
    mkdir($modelsDir, 0777, true);
}

// Save the trained model
$trainer->saveModel($modelsDir . '/model_' . $algorithm . '.rbx');