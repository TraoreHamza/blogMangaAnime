<?php
namespace App\EventListener;

use Psr\Log\LoggerInterface;
use App\Entity\Article;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Mailer\MailerInterface; 
use Symfony\Component\Mime\Email;

class ArticleListener
{
    private LoggerInterface $logger;
    private MailerInterface $mailer;

    public function __construct(LoggerInterface $logger, MailerInterface $mailer)
    {
        $this->logger = $logger;
        $this->mailer = $mailer;
    }

    public function onArticleCreated(Article $article, LifecycleEventArgs $args): void
    {
        // Log création
        $this->logger->info('Article créé : ' . $article->getTitle());

        // Envoyer une notification mail à l'admin
        $email = (new Email())
            ->from('Otaku@domaine.com')
            ->to('admin@admin.fr')
            ->subject('Nouvel article publié : '.$article->getTitle())
            ->text('Un nouvel article vient d\'être publié par '.$article->getAuthor()->getUsername());

        $this->mailer->send($email);

        // Exemple : appel à un service SEO pour optimiser metadonnées
        // $this->seoService->optimizeArticle($article);
    }

    public function onArticleUpdated(Article $article, LifecycleEventArgs $args): void
    {
        // Log mise à jour
        $this->logger->info('Article mis à jour : ' . $article->getTitle());

        // Logic pour purger le cache associé à l'article
        // $this->cacheService->invalidateArticleCache($article->getId());

        // Exemple : notifier les abonnés d’une série manga si l’article concerne celle-ci
        // $this->notificationService->notifySubscribers($article);
    }

    public function onArticleDeleted(Article $article, LifecycleEventArgs $args): void
    {
        // Log suppression
        $this->logger->info('Article supprimé : ' . $article->getTitle());

        // Supprimer l’image associée dans le dossier médias
        $imagePath = __DIR__ . '/../../public/medias/images/' . $article->getImage();
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Exemple : mettre à jour des stats ou logs externes
        // $this->statsService->decrementArticleCount();
    }
}
