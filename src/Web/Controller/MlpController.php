<?php

namespace Spark\Web\Controller;

use Spark\Web\Service\MlpService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MlpController extends AbstractController
{
    #[Route('/mlp', name: 'Mlp')]
    public function test(Request $request, MlpService $modelTestService): Response
    {
        if ($request->isMethod('POST') && $request->files->get('image')) {
            $uploadedFile = $request->files->get('image');

            if ($uploadedFile instanceof UploadedFile) {
                // Vérifier si le fichier est une image valide
                if (!$uploadedFile->isValid() || !in_array($uploadedFile->getMimeType(), ['image/png', 'image/jpeg'])) {
                    $this->addFlash('error', 'Veuillez uploader une image valide.');
                    return $this->redirectToRoute('Mlp');
                }

                // Sauvegarde temporaire de l'image
                $imagePath = $uploadedFile->getPathname();

                try {
                    $prediction = $modelTestService->testImage($imagePath);
                    $this->addFlash('success', "Le modèle a prédit le chiffre : $prediction");
                } catch (\Exception $e) {
                    $this->addFlash('error', $e->getMessage());
                }
            } else {
                $this->addFlash('error', 'Le fichier téléchargé n\est pas valide. ');
                return $this->redirectToRoute('Mlp');
            }
        }

        return $this->render('mlp.html.twig');
    }
}
