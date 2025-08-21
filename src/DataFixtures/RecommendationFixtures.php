<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\MangaAnime;
use App\Entity\Recommendation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RecommendationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
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
        $product = new Recommendation();
        $product
            ->setScore($faker->numberBetween(1, 10))
            ->setUser($faker->randomElement($users)) // Associe un utilisateur aléatoire
            ->setMangaAnime($faker->randomElement($mangaAnime)) // Associe une mangaAnime aléatoire
        ;
        $manager->persist($product);
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
