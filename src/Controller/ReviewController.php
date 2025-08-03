<?php

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewForm;
use App\Repository\ReviewRepository;
use App\Repository\MangaAnimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/review')]
class ReviewController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private ReviewRepository $reviewRepository,
        private MangaAnimeRepository $mangaAnimeRepository
    ) {}

    #[Route('/', name: 'review', methods: ['GET'])]
    public function index(): Response
    {
        $reviews = $this->reviewRepository->findAll();

        return $this->render('review/index.html.twig', [
            'reviews' => $reviews,
        ]);
    }

    #[Route('/new', name: 'review_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request): Response
    {
        $review = new Review();

        $form = $this->createForm(ReviewForm::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $review->setCreatedAt(new \DateTimeImmutable());
            $review->setUsers($this->getUser());

            $mangaAnimeId = $request->request->get('manga_anime_id');
            $mangaAnime = $this->mangaAnimeRepository->find($mangaAnimeId);

            if (!$mangaAnime) {
                $this->addFlash('error', 'Manga/Anime invalide.');
                return $this->redirectToRoute('review_new');
            }

            $review->setMangaAnimes($mangaAnime);

            $this->em->persist($review);
            $this->em->flush();

            $this->addFlash('success', 'Review créée avec succès.');

            return $this->redirectToRoute('review_index');
        }

        return $this->render('review/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'review_show', methods: ['GET'])]
    public function show(Review $review): Response
    {
        return $this->render('review/show.html.twig', [
            'review' => $review,
        ]);
    }

    #[Route('/{id}/edit', name: 'review_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, Review $review): Response
    {
        if ($this->getUser() !== $review->getUsers() && !$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Accès refusé');
            return $this->redirectToRoute('review_index');
        }

        $form = $this->createForm(ReviewForm::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            $this->addFlash('success', 'Review modifiée avec succès.');

            return $this->redirectToRoute('review_show', ['id' => $review->getId()]);
        }

        return $this->render('review/edit.html.twig', [
            'form' => $form->createView(),
            'review' => $review,
        ]);
    }

    #[Route('/{id}', name: 'review_delete', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function delete(Request $request, Review $review): Response
    {
        if ($this->isCsrfTokenValid('delete' . $review->getId(), $request->request->get('_token'))) {
            if ($this->getUser() === $review->getUsers() || $this->isGranted('ROLE_ADMIN')) {
                $this->em->remove($review);
                $this->em->flush();

                $this->addFlash('success', 'Review supprimée.');
            } else {
                $this->addFlash('error', 'Accès refusé.');
            }
        }

        return $this->redirectToRoute('review_index');
    }
}
