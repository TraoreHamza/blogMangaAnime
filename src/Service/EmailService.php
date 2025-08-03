<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    private string $fromEmail;

    public function __construct(
        private MailerInterface $mailer,
        string $fromEmail
    ) {
        $this->fromEmail = $fromEmail;
    }

    /**
     * Envoi un email générique avec sujet et message
     */
    public function sendInfoMail(string $subject, string $message, string $to): void
    {
        $email = (new Email())
            ->from($this->fromEmail)
            ->to($to)
            ->subject($subject)
            ->text($message);

        $this->mailer->send($email);
    }

    public function sendLoginNotification(User $user, array $info): void
    {
        $subject = "Notification de connexion";
        $message = sprintf(
            "Bonjour %s,\n\nUne connexion à votre compte a été détectée.\nDétails :\n%s\n\nSi ce n'était pas vous, veuillez contacter le support.",
            $user->getUsername(),
            print_r($info, true)
        );

        $this->sendInfoMail($subject, $message, $user->getEmail());
    }

    public function sendWarning(User $user, array $info): void
    {
        $subject = "Avertissement important";
        $message = sprintf(
            "Bonjour %s,\n\nVoici un avertissement concernant votre compte :\n%s\n\nMerci de prendre cela en considération.",
            $user->getUsername(),
            print_r($info, true)
        );

        $this->sendInfoMail($subject, $message, $user->getEmail());
    }

    public function sendRgpdExport(User $user, array $info): void
    {
        $subject = "Export de vos données RGPD";
        $message = sprintf(
            "Bonjour %s,\n\nVoici l'export de vos données conformément à la réglementation RGPD :\n%s\n\nCordialement.",
            $user->getUsername(),
            print_r($info, true)
        );

        $this->sendInfoMail($subject, $message, $user->getEmail());
    }

    public function sendAccountDeletion(array $info): void
    {
        $to = $info['email'] ?? null;

        if (!$to) {
            throw new \InvalidArgumentException("L'adresse email est requise pour envoyer la suppression de compte.");
        }

        $message = sprintf(
            "Bonjour,\n\nVotre compte a été supprimé avec succès. Détails :\n%s\n\nMerci pour votre temps chez nous.",
            print_r($info, true)
        );

        $this->sendInfoMail("Notification de suppression de compte", $message, $to);
    }
}
