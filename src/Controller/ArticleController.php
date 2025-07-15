<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    #[Route('/article/{id}', name: 'article_view', methods: ['GET'])]
    public function view(int $id): Response
    { /* ... */
        return $this->render('article/view.html.twig', [
            'article_id' => $id, // Fetch and pass the article
        ]);
    }

    #[Route('/article', name: 'article_create', methods: ['POST'])]
    public function create(): Response
    { /* ... */
        return new Response('Article created successfully.');
    }

    #[Route('/article/{id}/edit', name: 'article_edit', methods: ['PUT', 'PATCH'])]
    public function edit(int $id): Response
    { /* ... */
        return new Response('Article edited successfully.');
    }

    #[Route('/article/{id}', name: 'article_delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    { /* ... */
        return new Response('Article deleted successfully.');
    }

    #[Route('/article/{id}/validate', name: 'article_validate', methods: ['POST'])]
    public function validate(int $id): Response
    { /* ... */
        return new Response('Article validated successfully.');
    }
}
