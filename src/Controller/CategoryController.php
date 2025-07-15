<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    #[Route('/category', name: 'category_create', methods: ['POST'])]
    public function create(): Response
    { /* ... */
        return $this->redirectToRoute('app_category');
    }

    #[Route('/category/{id}', name: 'category_edit', methods: ['PUT', 'PATCH'])]
    public function edit(int $id): Response
    { /* ... */
        return new Response('Category edited successfully.');
    }

    #[Route('/category/{id}', name: 'category_delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    { /* ... */
        return new Response('Category deleted successfully.');
    }

    #[Route('/category/{id}/add-tag', name: 'category_add_tag', methods: ['POST'])]
    public function addTag(int $id): Response
    { /* ... */
        return new Response('Tag added to category successfully.');
    }

    #[Route('/category/{id}/remove-tag', name: 'category_remove_tag', methods: ['POST'])]
    public function removeTag(int $id): Response
    { /* ... */
        return new Response('Tag removed from category successfully.');
    }

    #[Route('/categories', name: 'category_get_all', methods: ['GET'])]
    public function getAll(): Response
    { /* ... */
        return $this->render('category/list.html.twig', [
            'categories' => [], // Fetch and pass the list of categories
        ]);
    }
}
