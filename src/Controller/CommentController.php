<?php

namespace App\Controller;


use App\Entity\Comment;
use App\Service\ModerationService;
use App\Repository\ReviewRepository;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CommentController extends AbstractController
{
    public function __construct(
        private CommentRepository $commentRepository,
        private EntityManagerInterface $em
    ) {}
    #[Route('/comment/new/{article}', name: 'comment_new', methods: ['POST'])]
    public function new(
        int $article,
        Request $request, // permet de gérer les requêtes HTTP (params, etc..)
        ArticleRepository $ar,
        EntityManagerInterface $em, // permet d'interagir avec la BDD
        ModerationService $ms,
        ReviewRepository $reviewRepository
    ): Response {
        $articleComment = $ar->find($article); // Récupération de l'article
        $user = $this->getUser(); // Récupération de l'utilisateur en cours
        if (!$article) { // Ce sera ignorer si l'article existe
            $this->addFlash('error', "L'article n'existe pas");
            return $this->redirectToRoute('articles');
        }

        // review
        $reviewId = $request->request->get('review_id');
        $review = null;
        if ($reviewId) {
            $review = $reviewRepository->find($reviewId);
            if (!$review) {
                $this->addFlash('error', "La review est introuvable");
                return $this->redirectToRoute('article', ['slug' => $articleComment->getSlug()]);
            }
        }
        $comment = new Comment();
        $comment
            ->setAuthor($user)
            ->setArticle($articleComment)
            ->setContent($request->request->get('content'))
        ;

        // Associer la review au commentaire si présente
        if ($review) {
            $comment->setReviews($review);
        }

        $em->persist($comment); // Enregistrement de l'article (query SQL)
        $em->flush($comment); // Exécution de l'enregistrement en BDD

        $ms->checkComment($comment); // Appel de la méthode de modération

        // dd($comment);

        $this->addFlash('success', "Votre commentaire est en cours de traitement");
        return $this->redirectToRoute('article', ['slug' => $articleComment->getSlug()]);
    }

    /**  DELETE - Suppression d’un commentaire */
    #[Route('/{id}/delete', name: 'comment_delete', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function delete(Request $request, Comment $comment): Response
    {
        if (!$this->isCsrfTokenValid('delete_comment_' . $comment->getId(), $request->request->get('_token'))) {
            $this->addFlash('error', 'Jeton CSRF invalide.');
            return $this->redirectToRoute('artcle', ['slug' => $comment->getArticle()->getSlug()]);
        }

        if ($comment->getAuthor() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous ne pouvez supprimer que vos commentaires.');
            return $this->redirectToRoute('article', ['slug' => $comment->getArticle()->getSlug()]);
        }

        // $this->em->remove($comment);
        // $this->em->flush();

        $this->addFlash('success', 'Commentaire supprimé.');
        return $this->redirect($request->headers->get('referer', '/'));
    }

    // Signalement d'un commentaire
    #[Route('/comment/{id}/report', name: 'comment_report', methods: ['POST'])]
    public function report(int $id, Request $request): Response
    {
        // Validation CSRF
        if (!$this->isCsrfTokenValid('report-comment-' . $id, $request->request->get('_token'))) {
            $this->addFlash('danger', 'Token CSRF invalide.');
            return $this->redirectToRoute('articles');
        }

        $comment = $this->commentRepository->find($id);
        if (!$comment) {
            $this->addFlash('danger', 'Commentaire introuvable.');
            return $this->redirectToRoute('articles');
        }

        // Ici on considère que signaler un commentaire met isModerated à true
        $comment->setIsModerated(true);
        $this->em->flush();

        $this->addFlash('warning', 'Le commentaire a été signalé et sera examiné.');

        // Retour vers la page précédente
        return $this->redirect($request->headers->get('referer') ?? $this->generateUrl('articles'));
    }
}
