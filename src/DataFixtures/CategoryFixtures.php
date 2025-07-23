<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Category;
use App\Entity\MangaAnime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CategoryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $categories = [
            'Action',
            'Aventure',
            'Comédie',
            'Drame',
            'Fantastique',
            'Horreur',
            'Surnaturel',
            'Romance',
            'Science-fiction',
            'Sport',
            'Thriller',
            'Mystère',
            'Dark Fantasy',
            'Super-héros',
            'Espionnage'
        ];

        $mangaAnimes = [];
        for ($i = 0; $i < 10; $i++) {
            $mangaAnimes[] = $this->getReference('MANGA_ANIME_' . $i, MangaAnime::class);
        }

        for ($i = 0; $i < 10; $i++) {
            foreach ($categories as $catName) {
                $category = new Category();
                $category
                    ->setName($catName)
                    ->addMangaAnime($faker->randomElement($mangaAnimes)) // Associe une mangaAnime aléatoire
                ;
                $manager->persist($category);
            }
            $this->addReference('CATEGORY_' . $i, $category);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            MangaAnimeFixtures::class,
        ];
    }
}
