<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\MangaAnime;
use App\Entity\User;
use App\Entity\Favori;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class FavoriteFixtures extends Fixture implements DependentFixtureInterface
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
        for($i = 0; $i < 10; $i++) {
            $users[] = $this->getReference('USER_' . $i, User::class);
        }

        for ($i = 0; $i < 10; $i++) {
        $favori = new Favori();
        $favori
            ->setCreatedAt(new \DateTimeImmutable())
            ->setMangaAnimes($faker->randomElement($mangaAnime)) // Associe une mangaAnime aléatoire
            ->setUsers($faker->randomElement($users)) // Associe un utilisateur aléatoire
            
        ;
        $manager->persist($favori);
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
