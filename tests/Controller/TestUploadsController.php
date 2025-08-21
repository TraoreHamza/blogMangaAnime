<?php

namespace App\Controller;

use App\Form\TestUploadType;
use App\Service\ImageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestUploadController extends AbstractController
{
    #[Route('/test-upload', name: 'test_upload')]
    public function index(Request $request, ImageService $imageService): Response
    {
        $form = $this->createForm(TestUploadType::class);
        $form->handleRequest($request);

        $fichierUpload = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('imageFile')->getData();

            if ($file) {
                $fichierUpload = $imageService->upload($file, 'image');
                $this->addFlash('success', 'Fichier uploadé sous le nom : ' . $fichierUpload);
            }
        }

        return $this->render('test_upload/index.html.twig', [
            'form' => $form->createView(),
            'fichierUpload' => $fichierUpload,
        ]);
    }
}
