<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\MangaAnime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class MangaAnimeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $MangaAnime = new MangaAnime();
            $MangaAnime
                ->setTitle($faker->sentence(3))
                ->setType($faker->randomElement(['Manga', 'Anime']))
                ->setReleaseDate($faker->dateTimeBetween('-10 years', 'now'))
                ->setPopularity($faker->numberBetween(1, 100))
                ->setSynopsis($faker->paragraph(3))
                ->setAuthor($faker->name())
                ->setStudio($faker->company())
                ->setCoverImage($faker->imageUrl(640, 480, 'anime', true, 'Faker'))
                ->setNumberOfVolumes($faker->numberBetween(1, 50))
                ->setNumberOfEpisodes($faker->numberBetween(1, 100))
            ;
            $manager->persist($MangaAnime);
            $this->addReference('MANGA_ANIME_' . $i, $MangaAnime);
        };

        $manager->flush();
    }
}
