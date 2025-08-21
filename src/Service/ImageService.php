<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService
{
    private array $typeArr = [];

    public function __construct(private ParameterBagInterface $params)
    {
        // Chemins complets vers les dossiers upload, dans public
        $this->typeArr = [
            'image' => $this->params->get('upload_folder') . '/images',
            'document' => $this->params->get('upload_folder') . '/docs',
            'other' => $this->params->get('upload_folder'),
        ];
    }

    public function upload(UploadedFile $file, string $type): string
    {
        try {
            // Création dossier si nécessaire
            if (!is_dir($this->typeArr[$type])) {
                mkdir($this->typeArr[$type], 0775, true);
            }

            $filename = uniqid($type . '-') . '.' . $file->guessExtension();
            $file->move($this->typeArr[$type], $filename);
        } catch (\Exception $err) {
            throw new \RuntimeException('Erreur lors de l upload du fichier : ' . $err->getMessage());
        }

        return $filename;
    }

    public function delete(string $filename, string $type): void
    {
        $file = $this->typeArr[$type] . '/' . $filename;

        if (file_exists($file)) {
            unlink($file);
        }
    }
}
