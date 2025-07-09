<?php

namespace App\DataFixtures;

use App\Entity\MangaAnime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class MangaAnimeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $MangaAnime = new MangaAnime();
        $MangaAnime
            ->setTitle('Attack on Titan')
            ->setType('Anime');
        // $manager->persist($product);

        $manager->flush();
    }
}
