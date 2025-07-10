<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Review;
use App\Entity\Comment;
use App\Entity\MangaAnime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ReviewFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        //  Recuperation des mangaAnime nouvellement crées
        $mangaAnime = [];
        for ($i = 0; $i < 10; $i++) {
            $mangaAnime[] = $this->getReference('MANGA_ANIME_' . $i, MangaAnime::class);
        }
        //  Recuperation des utilisateur nouvellement crées
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $users[] = $this->getReference('USER_' . $i, User::class);
        }


        for ($i = 0; $i < 10; $i++) {
            $review = new Review();
            $review
                ->setContent($faker->paragraph(3))
                ->setRating($faker->numberBetween(1, 5))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setStatus($faker->randomElement()) // Statut aléatoire
                ->setMangaAnimes($faker->randomElement($mangaAnime)) // Associe une mangaAnime aléatoire
                ->setUsers($faker->randomElement($users)) // Associe un utilisateur aléatoire
            ;
            $manager->persist($review);
            $this->addReference('REVIEW_' . $i, $review);
        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            MangaAnimeFixtures::class,
            UserFixtures::class,
        ];
    }
}
