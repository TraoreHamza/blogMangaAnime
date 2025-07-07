<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecommendationController extends AbstractController
{
    #[Route('/recommendation', name: 'app_recommendation')]
    public function index(): Response
    {
        return $this->render('recommendation/index.html.twig', [
            'controller_name' => 'RecommendationController',
        ]);
    }
}
