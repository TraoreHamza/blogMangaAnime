<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Review;
use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        //  Recuperation des mangaAnime nouvellement crées
        $article = [];
        for ($i = 0; $i < 10; $i++) {
            $article[] = $this->getReference('ARTICLE_' . $i, Article::class);
        }
        //  Recuperation des utilisateur nouvellement crées
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $users[] = $this->getReference('USER_' . $i, User::class);
        }

        //  Recuperation des utilisateur nouvellement crées
        $reviews = [];
        for ($i = 0; $i < 10; $i++) {
            $reviews[] = $this->getReference('REVIEW_' . $i, Review::class);
        }
        for ($i = 0; $i < 10; $i++) {
            $comment = new Comment();
            $comment
                ->setContent($faker->paragraph(3))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setIsModerated($faker->boolean(80)) // 80% de chance que le commentaire soit modéré
                ->setIsPublished($faker->boolean(90)) // 90% de chance que le commentaire soit publié
                ->setAuthor($faker->randomElement($users)) // Associe un utilisateur aléatoire
                ->setArticle($faker->randomElement($article)) // Associe un article aléatoire
                ->setReviews($faker->randomElement($reviews)) // Associe une review aléatoire
            ;
            $manager->persist($comment);
        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            ArticleFixtures::class,
            UserFixtures::class,
            ReviewFixtures::class,
        ];
    }
}
