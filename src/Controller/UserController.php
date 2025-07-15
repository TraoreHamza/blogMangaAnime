<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/user')]
class UserController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {}
    #[Route('/profile', name: 'user_profile', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/new-password', name: 'user_new_password', methods: ['POST'])]
    public function newPassword(Request $request): Response
    { 
        // Handle new password logic here
        // For example, validate the request, change the password, etc.
        $data = json_decode($request->getContent(), true);
        if (isset($data['new_password'])) {
            // Logic to change the password
            // ...

            return new Response('Password changed successfully', Response::HTTP_OK);
        }

        return new Response('Invalid request', Response::HTTP_BAD_REQUEST);
    }

    #[Route('/edit-profile', name: 'user_edit_profile', methods: ['PUT', 'PATCH'])]
    public function editProfile(): Response
    { /* ... */
        // Logic to edit user profile
        // For example, update user information, etc.
        return new Response('Profile updated successfully.');   
    }

    #[Route('/my-data', name: 'user_my_data', methods: ['GET'])]
    public function myData(): Response
    { /* ... */
        return new Response('User data retrieved successfully.');
    }

    #[Route('/user/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    { /* ... */
        // Logic to delete user
        // For example, remove user from the database, etc.
        return new Response('User deleted successfully.');
    }
}
