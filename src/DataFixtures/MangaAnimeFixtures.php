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

        $data = [
            [
                'title' => 'One Piece',
                'type' => 'manga',
                'releaseDate' => new \DateTime('1997-07-22'),
                'popularity' => 100,
                'synopsis' => 'Luffy et son équipage partent à la recherche du One Piece.',
                'author' => 'Eiichiro Oda',
                'studio' => 'Toei Animation',
                'coverImage' => 'onepiece.jpg',
                'numberOfVolumes' => 105,
                'numberOfEpisodes' => 1100,
            ],
            [
                'title' => 'Attack on Titan',
                'type' => 'anime',
                'releaseDate' => new \DateTime('2013-04-07'),
                'popularity' => 95,
                'synopsis' => "L'humanité lutte pour survivre face aux Titans.",
                'author' => 'Hajime Isayama',
                'studio' => 'Wit Studio',
                'coverImage' => 'aot.jpg',
                'numberOfVolumes' => 34,
                'numberOfEpisodes' => 87,
            ],
            [
                'title' => 'Demon Slayer',
                'type' => 'anime',
                'releaseDate' => new \DateTime('2019-04-06'),
                'popularity' => 90,
                'synopsis' => 'Tanjiro combat les démons pour sauver sa sœur.',
                'author' => 'Koyoharu Gotouge',
                'studio' => 'ufotable',
                'coverImage' => 'demonslayer.jpg',
                'numberOfVolumes' => 23,
                'numberOfEpisodes' => 55,
            ],
            [
                'title' => 'Naruto',
                'type' => 'manga',
                'releaseDate' => new \DateTime('1999-09-21'),
                'popularity' => 98,
                'synopsis' => 'Naruto Uzumaki rêve de devenir Hokage.',
                'author' => 'Masashi Kishimoto',
                'studio' => 'Pierrot',
                'coverImage' => 'naruto.jpg',
                'numberOfVolumes' => 72,
                'numberOfEpisodes' => 720,
            ],
            [
                'title' => 'My Hero Academia',
                'type' => 'anime',
                'releaseDate' => new \DateTime('2016-04-03'),
                'popularity' => 85,
                'synopsis' => "Izuku Midoriya veut devenir un héros dans un monde où 80% de la population a un pouvoir.",
                'author' => 'Kohei Horikoshi',
                'studio' => 'Bones',
                'coverImage' => 'mha.jpg',
                'numberOfVolumes' => 38,
                'numberOfEpisodes' => 138,
            ],
            [
                'title' => 'Fullmetal Alchemist',
                'type' => 'manga',
                'releaseDate' => new \DateTime('2001-07-12'),
                'popularity' => 92,
                'synopsis' => 'Edward et Alphonse Elric cherchent la pierre philosophale.',
                'author' => 'Hiromu Arakawa',
                'studio' => 'Bones',
                'coverImage' => 'fma.jpg',
                'numberOfVolumes' => 27,
                'numberOfEpisodes' => 64,
            ],
            [
                'title' => 'Death Note',
                'type' => 'manga',
                'releaseDate' => new \DateTime('2003-12-01'),
                'popularity' => 91,
                'synopsis' => 'Light Yagami découvre un carnet qui tue.',
                'author' => 'Tsugumi Ohba',
                'studio' => 'Madhouse',
                'coverImage' => 'deathnote.jpg',
                'numberOfVolumes' => 12,
                'numberOfEpisodes' => 37,
            ],
            [
                'title' => 'Dragon Ball',
                'type' => 'manga',
                'releaseDate' => new \DateTime('1984-11-20'),
                'popularity' => 99,
                'synopsis' => 'Son Goku part à la recherche des Dragon Balls.',
                'author' => 'Akira Toriyama',
                'studio' => 'Toei Animation',
                'coverImage' => 'dragonball.jpg',
                'numberOfVolumes' => 42,
                'numberOfEpisodes' => 153,
            ],
            [
                'title' => 'Bleach',
                'type' => 'manga',
                'releaseDate' => new \DateTime('2001-08-07'),
                'popularity' => 87,
                'synopsis' => 'Ichigo Kurosaki devient Shinigami pour protéger les humains.',
                'author' => 'Tite Kubo',
                'studio' => 'Pierrot',
                'coverImage' => 'bleach.jpg',
                'numberOfVolumes' => 74,
                'numberOfEpisodes' => 366,
            ],
            [
                'title' => 'Jujutsu Kaisen',
                'type' => 'anime',
                'releaseDate' => new \DateTime('2020-10-03'),
                'popularity' => 89,
                'synopsis' => "Yuji Itadori combat des fléaux avec l'aide de Satoru Gojo.",
                'author' => 'Gege Akutami',
                'studio' => 'MAPPA',
                'coverImage' => 'jujutsu.jpg',
                'numberOfVolumes' => 25,
                'numberOfEpisodes' => 47,
            ],

            [
                'title' => 'Spy x Family',
                'type' => 'anime',
                'releaseDate' => new \DateTime('2022-04-09'),
                'popularity' => 87,
                'synopsis' => "Loid, espion, forme une famille fictive avec Yor et Anya pour une mission secrète.",
                'author' => 'Tatsuya Endo',
                'studio' => 'Wit Studio & CloverWorks',
                'coverImage' => 'spyxfamily.jpg',
                'numberOfVolumes' => 14,
                'numberOfEpisodes' => 25,
            ],
            [
                'title' => 'Chainsaw Man',
                'type' => 'anime',
                'releaseDate' => new \DateTime('2025-07-01'),
                'popularity' => 85,
                'synopsis' => "Denji combat des démons avec une tronçonneuse dans un univers violent et décalé.",
                'author' => 'Tatsuki Fujimoto',
                'studio' => 'MAPPA',
                'coverImage' => 'chainsawman.jpg',
                'numberOfVolumes' => 11,
                'numberOfEpisodes' => 24,
            ],
            [
                'title' => 'Blue Lock: Second Selection',
                'type' => 'anime',
                'releaseDate' => new \DateTime('2025-04-01'),
                'popularity' => 82,
                'synopsis' => "Une compétition pour devenir l’attaquant numéro un du Japon dans un manga de football intense.",
                'author' => 'Muneyuki Kaneshiro',
                'studio' => '8bit',
                'coverImage' => 'bluelock.jpg',
                'numberOfVolumes' => 20,
                'numberOfEpisodes' => 24,
            ],
            [
                'title' => 'Kaiju No. 8',
                'type' => 'anime',
                'releaseDate' => new \DateTime('2025-06-01'),
                'popularity' => 83,
                'synopsis' => "Un homme capable de se transformer en monstre géant lutte contre les kaijus au Japon.",
                'author' => 'Naoya Matsumoto',
                'studio' => 'Production I.G',
                'coverImage' => 'kaijuno8.jpg',
                'numberOfVolumes' => 12,
                'numberOfEpisodes' => 24,
            ],
            [
                'title' => 'Dandadan',
                'type' => 'anime',
                'releaseDate' => new \DateTime('2025-08-01'),
                'popularity' => 80,
                'synopsis' => "Un mélange d’occultisme, science-fiction et romance adolescente avec beaucoup d’action.",
                'author' => 'Yukinobu Tatsu',
                'studio' => 'Science SARU',
                'coverImage' => 'dandadan.jpg',
                'numberOfVolumes' => 5,
                'numberOfEpisodes' => 12,
            ],
            [
                'title' => 'Omniscient Reader',
                'type' => 'anime',
                'releaseDate' => new \DateTime('2025-09-01'),
                'popularity' => 78,
                'synopsis' => "Un homme plongé dans un monde apocalyptique inspiré de son roman web préféré.",
                'author' => 'sing N song & UMI',
                'studio' => 'MAPPA',
                'coverImage' => 'omniscientreader.jpg',
                'numberOfVolumes' => 10,
                'numberOfEpisodes' => 24,
            ],
            [
                'title' => 'Solo Leveling',
                'type' => 'anime',
                'releaseDate' => new \DateTime('2025-10-01'),
                'popularity' => 88,
                'synopsis' => "Sung Jin-Woo, le chasseur le plus faible, devient le plus puissant dans un monde de monstres.",
                'author' => 'Chugong',
                'studio' => 'A-1 Pictures',
                'coverImage' => 'sololeveling.jpg',
                'numberOfVolumes' => 14,
                'numberOfEpisodes' => 24,
            ],
            [
                'title' => 'Tokyo Revengers',
                'type' => 'anime',
                'releaseDate' => new \DateTime('2021-04-11'),
                'popularity' => 86,
                'synopsis' => "Takemichi Hanagaki voyage dans le temps pour sauver son ex-petite amie et changer son destin.",
                'author' => 'Ken Wakui',
                'studio' => 'LIDENFILMS',
                'coverImage' => 'tokyorevengers.jpg',
                'numberOfVolumes' => 30,
                'numberOfEpisodes' => 24,
            ],
            [
                'title' => 'Vinland Saga',
                'type' => 'anime',
                'releaseDate' => new \DateTime('2019-07-07'),
                'popularity' => 84,
                'synopsis' => "Thorfinn, fils d’un guerrier viking, cherche à venger la mort de son père.",
                'author' => 'Makoto Yukimura',
                'studio' => 'Wit Studio',
                'coverImage' => 'vinlandsaga.jpg',
                'numberOfVolumes' => 12,
                'numberOfEpisodes' => 24,
            ],
            [
                'title' => 'Mob Psycho 100',
                'type' => 'anime',
                'releaseDate' => new \DateTime('2016-07-11'),
                'popularity' => 81,
                'synopsis' => "Shigeo Kageyama, un jeune garçon avec des pouvoirs psychiques, cherche à mener une vie normale.",
                'author' => 'ONE',
                'studio' => 'Bones',
                'coverImage' => 'mobpsycho100.jpg',
                'numberOfVolumes' => 16,
                'numberOfEpisodes' => 36,
            ],
            [
                'title' => 'The Rising of the Shield Hero',
                'type' => 'anime',
                'releaseDate' => new \DateTime('2019-01-09'),
                'popularity' => 79,
                'synopsis' => "Naofumi Iwatani est invoqué dans un monde fantastique en tant que héros du bouclier.",
                'author' => 'Aneko Yusagi',
                'studio' => 'Kinema Citrus',
                'coverImage' => 'shieldhero.jpg',
                'numberOfVolumes' => 22,
                'numberOfEpisodes' => 25,
            ],
            [
                'title' => 'Berserk',
                'type' => 'manga',
                'releaseDate' => new \DateTime('1989-08-25'),
                'popularity' => 93,
                'synopsis' => 'Guts, un mercenaire solitaire, lutte contre des forces démoniaques dans un monde médiéval sombre.',
                'author' => 'Kentaro Miura',
                'studio' => 'Madhouse',
                'coverImage' => 'berserk.jpg',
                'numberOfVolumes' => 41,
                'numberOfEpisodes' => 25,
            ],
            [
                'title' => 'Dragon Ball',
                'type' => 'manga',
                'releaseDate' => new \DateTime('1984-11-20'),
                'popularity' => 99,
                'synopsis' => 'Son Goku part à la recherche des Dragon Balls et devient un puissant guerrier.',
                'author' => 'Akira Toriyama',
                'studio' => 'Toei Animation',
                'coverImage' => 'dragonball.jpg',
                'numberOfVolumes' => 42,
                'numberOfEpisodes' => 153,
            ],
            [
                'title' => 'Hunter x Hunter',
                'type' => 'manga',
                'releaseDate' => new \DateTime('1998-03-03'),
                'popularity' => 90,
                'synopsis' => "Gon Freecss part à la recherche de son père et devient Hunter.",
                'author' => 'Yoshihiro Togashi',
                'studio' => 'Madhouse',
                'coverImage' => 'hunterxhunter.jpg',
                'numberOfVolumes' => 36,
                'numberOfEpisodes' => 148,
            ],
        ];

        $i = 0; // Compteur pour les références

        for ($i = 0; $i < 10; $i++) {
            foreach ($data as $item) {
                $MangaAnime = new MangaAnime();
                $MangaAnime
                    ->setTitle($item['title'])
                    ->setType($item['type'])
                    ->setReleaseDate($item['releaseDate'])
                    ->setPopularity($item['popularity'])
                    ->setSynopsis($item['synopsis'])
                    ->setAuthor($item['author'])
                    ->setStudio($item['studio'])
                    ->setCoverImage($item['coverImage'])
                    ->setNumberOfVolumes($item['numberOfVolumes'])
                    ->setNumberOfEpisodes($item['numberOfEpisodes'])
                ;
                $manager->persist($MangaAnime);
                $this->addReference('MANGA_ANIME_' . $i, $MangaAnime);
                $i++; 
            }
        }

        $manager->flush();
    }
}
