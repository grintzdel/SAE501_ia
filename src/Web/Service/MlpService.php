<?php

namespace Spark\Web\Service;

use Rubix\ML\Datasets\Unlabeled;

class MlpService
{
    private mixed $model;
    const string PATH_MODEL_MLP = __DIR__ . '/../../public/model_mlp.rbx';

    public function __construct()
    {
        $modelPath = self::PATH_MODEL_MLP;

        try {
            if (!file_exists($modelPath)) {
                throw new \RuntimeException("Le fichier du modèle n'existe pas à l'emplacement spécifié : $modelPath");
            }

            $this->model = unserialize(file_get_contents($modelPath));

            if (!$this->model) {
                throw new \RuntimeException("Erreur lors de la désérialisation du modèle.");
            }
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors du chargement du modèle : " . $e->getMessage());
        }
    }

    public function testImage(string $imagePath): ?int
    {
        if (!file_exists($imagePath)) {
            throw new \RuntimeException("L'image spécifiée n'existe pas : $imagePath");
        }

        $sample = $this->prepareImage($imagePath);
        $dataset = new Unlabeled([$sample]);

        try {
            $prediction = $this->model->predict($dataset);
            return isset($prediction[0]) ? (int)$prediction[0] : null;
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la prédiction : " . $e->getMessage());
        }
    }

    private function prepareImage(string $imagePath): array
    {
        // Vérifier si le fichier est une image avec getimagesize()
        $imageInfo = getimagesize($imagePath);
        if ($imageInfo === false) {
            throw new \RuntimeException("Le fichier spécifié n'est pas une image valide : $imagePath");
        }

        $width = $imageInfo[0];
        $height = $imageInfo[1];

        // Vérifier que l'image est bien de taille 28x28
        if ($width !== 28 || $height !== 28) {
            throw new \RuntimeException("L'image doit être de taille 28x28 pixels.");
        }

        // Charger l'image en mémoire
        $image = @imagecreatefromstring(file_get_contents($imagePath));
        if (!$image) {
            throw new \RuntimeException("Impossible de charger l'image : $imagePath");
        }

        // Convertir les pixels en niveaux de gris normalisés
        $pixels = [];
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $rgb = imagecolorat($image, $x, $y);
                $red = ($rgb >> 16) & 0xFF;
                $green = ($rgb >> 8) & 0xFF;
                $blue = $rgb & 0xFF;
                $gray = ($red + $green + $blue) / 3; // Conversion en niveau de gris
                $pixels[] = $gray / 255; // Normalisation entre 0 et 1
            }
        }

        // Libérer la mémoire utilisée par l'image
        imagedestroy($image);

        return $pixels;
    }
}