<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Admin
        $admin = new User();
        $admin
            ->setEmail('admin@admin.fr')
            ->setUsername('admin')
            ->setPassword($this->hasher->hashPassword($admin, 'admin'))
            ->setWarningCount(0)
            ->setRoles(['ROLE_ADMIN'])
        ;
        $manager->persist($admin);
        $manager->flush();

        // Création de 10 articles
        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article
                ->setTitle($faker->sentence(6, true))
                ->setContent($faker->paragraphs(3, true))
                ->setSlug($faker->slug())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setImage($faker->imageUrl(640, 480, 'nature', true, 'Faker'))
                ->setStatus($faker->randomElement(['draft', 'published', 'archived']))
                ->setAuthor($admin)
            ;
            $manager->persist($article);
            $this->addReference('ARTICLE_' . $i, $article);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
