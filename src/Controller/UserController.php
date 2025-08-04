<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

#[Route('/user')]
class UserController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    #[Route('/profile', name: 'user_profile', methods: ['GET'])]
    public function profile(#[CurrentUser] ?User $user): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/new-password', name: 'user_new_password', methods: ['GET', 'POST'])]
    public function newPassword(Request $request, #[CurrentUser] ?User $user): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createFormBuilder()
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Nouveau mot de passe'],
                'second_options' => ['label' => 'Confirmez le mot de passe'],
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'required' => true,
                'mapped' => false,
            ])
            ->add('submit', SubmitType::class, ['label' => 'Modifier mot de passe'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', 'Mot de passe mis à jour avec succès.');

            return $this->redirectToRoute('user_profile');
        }

        return $this->render('user/new_password.html.twig', [
            'passwordForm' => $form->createView(),
        ]);
    }

    #[Route('/edit-profile', name: 'user_edit_profile', methods: ['GET', 'POST'])]
    public function editProfile(Request $request, #[CurrentUser] ?User $user): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createFormBuilder($user)
            ->add('name', TextType::class, ['label' => 'Nom complet'])
            ->add('email', TextType::class, ['label' => 'Email'])
            ->add('submit', SubmitType::class, ['label' => 'Mettre à jour'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Validation ici si besoin

            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', 'Profil mis à jour avec succès.');

            return $this->redirectToRoute('user_profile');
        }

        return $this->render('user/edit_profile.html.twig', [
            'profileForm' => $form->createView(),
        ]);
    }

    #[Route('/my-data', name: 'user_my_data', methods: ['GET'])]
    public function myData(#[CurrentUser] ?User $user): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Exemple simple : affiche les infos personnelles
        return $this->render('user/my_data.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/delete', name: 'user_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, #[CurrentUser] ?User $user): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($request->isMethod('POST')) {
            // Supprimer l'utilisateur
            $this->em->remove($user);
            $this->em->flush();

            $this->addFlash('success', 'Votre compte a été supprimé.');

            // Déconnexion et redirection ici - à adapter selon ton système
            return $this->redirectToRoute('app_home');
        }

        return $this->render('user/delete.html.twig');
    }
}
