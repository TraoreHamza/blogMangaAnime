<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CommentController extends AbstractController
{
    #[Route('/comment', name: 'app_comment')]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    #[Route('/comment', name: 'comment_create', methods: ['POST'])]
    public function create(): Response
    { /* ... */
        return new Response('Comment created successfully.');
    }

    #[Route('/comment/{id}', name: 'comment_edit', methods: ['PUT', 'PATCH'])]
    public function edit(int $id): Response
    { /* ... */
        return new Response('Comment edited successfully.');
    }

    #[Route('/comment/{id}', name: 'comment_delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    { /* ... */
        return new Response('Comment deleted successfully.');
    }

    #[Route('/comments/article/{articleId}', name: 'comment_get_all_by_article', methods: ['GET'])]
    public function getAllByArticle(int $articleId): Response
    { /* ... */
        return $this->render('comment/list.html.twig', [
            'comments' => [], // Fetch and pass the list of comments for the article
        ]);
    }

    #[Route('/comments/review/{reviewId}', name: 'comment_get_all_by_review', methods: ['GET'])]
    public function getAllByReview(int $reviewId): Response
    { /* ... */
        return $this->render('comment/list.html.twig', [
            'comments' => [], // Fetch and pass the list of comments for the review
        ]);
    }

    #[Route('/comment/{id}/report', name: 'comment_report', methods: ['POST'])]
    public function report(int $id): Response
    { /* ... */
        return new Response('Comment reported successfully.');
    }
}
