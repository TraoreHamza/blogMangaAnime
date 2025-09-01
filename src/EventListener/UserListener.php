<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;

class UserListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onUserLogin(): void
    {
        $this->logger->info('Un utilisateur s’est connecté');
        // Traiter connexion (ex: logging, stats)
    }

    public function onUserValidated(): void
    {
        $this->logger->info('Un utilisateur a été validé');
        // Traiter validation utilisateur
    }
}
