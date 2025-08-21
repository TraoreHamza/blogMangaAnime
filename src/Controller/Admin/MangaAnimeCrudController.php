<?php

namespace App\Controller\Admin;

use App\Entity\MangaAnime;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MangaAnimeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MangaAnime::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('type')
                ->setRequired(true)
                ->setHelp('Type of the manga or anime, e.g., "Manga", "Anime", etc.'),
            DateField::new('releaseDate')
                ->setRequired(true)
                ->setHelp('Release date of the manga or anime in YYYY-MM-DD format.'),
            TextEditorField::new('synopsis')
                ->setRequired(true)
                ->setHelp('A brief synopsis of the manga or anime.'),
            IntegerField::new('popularity')
                ->setRequired(true)
                ->setHelp('Popularity rating of the manga or anime, e.g., from 1 to 100.'),
            TextField::new('author')
                ->setRequired(true)
                ->setHelp('Name of the author or creator of the manga or anime.'),
            TextField::new('studio')
                ->setRequired(true)
                ->setHelp('Studio that produced the anime, if applicable.'),
            TextField::new('genre')
                ->setRequired(true)
                ->setHelp('Genre of the manga or anime, e.g., "Action", "Romance", etc.'),
            IntegerField::new('numberOfVolumes')
                ->setRequired(true)
                ->setHelp('Current status of the manga or anime, e.g., "Ongoing", "Completed".'),
            IntegerField::new('numberOfEpisodes')
                ->setRequired(true)
                ->setHelp('Current status of the manga or anime, e.g., "Ongoing ", "Completed".'),
            ImageField::new('image')
                ->setBasePath('medias/images/')
                ->setUploadDir('public/medias/images/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false)
        ];
    }
}
