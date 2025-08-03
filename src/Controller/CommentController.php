<?php

namespace App\Controller;


use App\Entity\Comment;
use App\Service\ModerationService;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CommentController extends AbstractController
{
    #[Route('/comment/new/{article}', name: 'comment_new', methods: ['POST'])]
    public function new(
            int $article, 
            Request $request, // permet de gérer les requêtes HTTP (params, etc..)
            ArticleRepository $ar,
            EntityManagerInterface $em, // permet d'interagir avec la BDD
            ModerationService $ms,
            // ReviewRepository $reviewRepository
    ): Response {
        $articleComment = $ar->find($article); // Récupération de l'article
        $user = $this->getUser(); // Récupération de l'utilisateur en cours
        if(!$article) { // Ce sera ignorer si l'article existe
            $this->addFlash('error', "L'article n'existe pas");
            return $this->redirectToRoute('articles');
        }

        $comment = new Comment();
        $comment
            ->setAuthor($user)
            ->setArticle($articleComment)
            ->setContent($request->request->get('content'))
        ;

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

    /**  REPORT - Signalement d’abus */
    #[Route('/{id}/report', name: 'comment_report', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function report(Request $request, Comment $comment): Response
    {
        // Exemple simple : on ajoute un flag (peut être ajouté à l'entité)
        $comment->setIsModerated(true); // Tu peux créer un champ `isReported` si besoin

        // $this->em->flush();

        $this->addFlash('success', 'Commentaire signalé à un modérateur.');
        return $this->redirect($request->headers->get('referer', '/'));
    }
}
