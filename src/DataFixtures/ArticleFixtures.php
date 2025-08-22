<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Article;
use App\Entity\Category;
use Cocur\Slugify\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
    ) {}

    public function load(ObjectManager $manager): void
    {
        $slugger = new Slugify();
        $faker = Factory::create('fr_FR');

        // Admin
        $admin = new User();
        $admin
            ->setEmail('admin@admin.fr')
            ->setUsername('admin')
            ->setPassword($this->hasher->hashPassword($admin, 'admin'))
            ->setWarningCount(0)
            ->setRoles(['ROLE_ADMIN'])
            ->setIsBanned(false)
            ->setIsActive(true)
            ->setIsVerified(true)
        ;

        $manager->persist($admin);
        $manager->flush(); // Admin enregistré en base de données

        $articles = [
            "One Piece : la géographie du monde et ses secrets",
            "L’évolution graphique et animation dans L’Attaque des Titans",
            "Naruto : les clans et leur influence sur l’histoire",
            "Les leçons de vie à tirer des personnages de Jujutsu Kaisen",
            "Dragon Ball Super : comment la série a redéfini l’univers de Dragon Ball",
            "L’Attaque des Titans : les thèmes de la liberté et de la survie",
            "Demon Slayer : l’importance de la musique et de la bande-son",
            "Hunter x Hunter : les stratégies de combat et leur complexité",
            "One Piece : les arcs narratifs les plus marquants",
            "Naruto : l’évolution des techniques de combat à travers les saisons",
            "Jujutsu Kaisen : les combats emblématiques et leur chorégraphie",
            "Dragon Ball : l’impact de la série sur la culture pop mondiale",
            "L’Attaque des Titans : les révélations qui ont choqué les fans",
            "Demon Slayer : la symbolique des couleurs et des motifs dans les costumes",
            "Hunter x Hunter : les personnages secondaires qui volent la vedette",
            "One Piece : les trésors et reliques légendaires du monde",
            "Naruto : les rivalités qui ont défini la série",
            "Jujutsu Kaisen : l’évolution des pouvoirs des personnages principaux",
            "Dragon Ball Z : les transformations les plus puissantes",
            "L’Attaque des Titans : les batailles épiques et leur impact émotionnel",
            "Blue Lock : l’ascension du football japonais à travers l’animation",
            "Vinland Saga : la saga viking qui redéfinit l’animation historique",
            "Tokyo Revengers : le voyage dans le temps et ses conséquences",
            "Mob Psycho 100 : la psychologie derrière les pouvoirs psychiques",
            "Death Note : l’intellect et la stratégie dans le jeu du chat et de la souris",
            "My Hero Academia : l’évolution des super-héros dans l’animation",
            "Black Clover : la magie et la camaraderie dans un monde fantastique",
            "Fairy Tail : l’amitié et la magie au cœur de l’aventure",
            "Dr . Stone : la science et la technologie dans un monde préhistorique",
        ];

        $content = [
            "One Piece est une série emblématique qui a captivé des millions de fans à travers le monde. Nous explorons les thèmes de l'amitié, de la liberté et de l'aventure qui font de cette série un incontournable.",
            "L'Attaque des Titans a révolutionné l'animation avec son approche réaliste et ses thèmes sombres. Nous discutons de son influence sur d'autres œuvres et de son héritage durable dans le monde de l'animation.",
            "Naruto est connu pour ses personnages mémorables et ses arcs narratifs captivants. Nous analysons comment la série a évolué au fil des ans et son impact sur la culture pop mondiale.",
            "Jujutsu Kaisen a rapidement gagné en popularité grâce à son mélange d'action surnaturelle et de drame émotionnel. Nous examinons les raisons de son succès et ce qui le distingue des autres séries shonen.",
            "Dragon Ball Super a redéfini l'univers de Dragon Ball avec de nouvelles transformations et des combats épiques. Nous discutons des changements apportés à la série et de leur impact sur les fans.",
            "Demon Slayer est célèbre pour son animation époustouflante et sa bande-son immersive. Nous explorons comment ces éléments contribuent à l'expérience globale de la série.",
            "Hunter x Hunter est connu pour ses arcs narratifs complexes et ses personnages profonds. Nous examinons les arcs les plus intenses, tels que l'arc des Chimera Ants, et comment ils ont façonné l'évolution des personnages principaux.",
            "One Piece suit Luffy et son équipage dans leur longue aventure vers le mythique trésor. Découvrez les secrets, les légendes et les enjeux cachés derrière cette quête qui passionne des millions de fans depuis plus de 20 ans.",
            "Naruto et sa suite, Naruto Shippuden, ont marqué l’histoire de l’animation japonaise. Nous explorons l’héritage de Naruto, ses thèmes de camaraderie et de persévérance, et comment il a influencé la culture pop mondiale.",
            "Jujutsu Kaisen se distingue par ses combats dynamiques et ses pouvoirs uniques. Nous plongeons dans l'univers des malédictions et des techniques de combat, en mettant en lumière les personnages clés et leurs capacités.",
            "Dragon Ball Z a offert des affrontements épiques qui ont marqué toute une génération. Nous revenons sur les combats emblématiques, tels que ceux entre Goku et Vegeta, ou Goku et Freezer, et comment ils ont redéfini les standards des combats dans l'animation.",
            "L’Attaque des Titans a laissé une empreinte indélébile dans le monde de l'animation avec sa fin controversée. Nous analysons les thèmes abordés dans la série, tels que la liberté et le sacrifice, et comment ils ont été traités dans les derniers épisodes.",
            "Demon Slayer ne séduit pas seulement par son histoire émouvante, mais aussi par son style graphique et son animation révolutionnaires. Nous détaillons comment l’esthétique sert la narration et nourrit l’émotion.",
            "L'équipage du Chapeau de paille est composé de personnages uniques et mémorables. Nous présentons chaque membre, leurs rêves et comment ils contribuent à l'aventure collective vers le One Piece.",
            "Naruto est connu pour ses transformations emblématiques. Nous expliquons la signification de chaque transformation et son impact sur l'histoire et les personnages.",
            "Les antagonistes jouent un rôle crucial dans les shonens modernes. Nous analysons  comment des personnages comme Madara Uchiha, Meruem de Hunter x Hunter et Muzan Kibutsuji de Demon Slayer enrichissent l'intrigue et poussent les héros à se surpasser.",
            "Naruto et Jujutsu Kaisen partagent des thèmes communs, mais leurs univers sont distincts. Nous comparons les systèmes de combat, les personnages et les philosophies sous-jacentes, en mettant en évidence les forces et les faiblesses de chaque série.",
            "Les scènes d’action dans Hunter x Hunter et Dragon Ball sont emblématiques. Nous revenons sur les moments clés, comme la bataille contre Netero et Meruem, ou le combat contre Cell, qui ont défini ces séries et captivé les fans.",
            "Demon Slayer met en avant des relations familiales complexes. Nous explorons la dynamique entre Tanjiro et Nezuko, ainsi que d'autres relations familiales dans la série, et comment elles influencent les motivations des personnages et l'intrigue.",
        ];

        $images = [
            'onepiece.jpg',
            'aot.jpg',
            'naruto.jpg',
            'demonslayer.jpg',
            'jujutsukaisen.jpg',
        ];

        $categories = [
            'Manga',
            'Series',
            'Films',
        ];

        $catArray = [];
        foreach ($categories as $category) {
            $cat = new Category();
            $cat->setName($category);

            $manager->persist($cat);
            array_push($catArray, $cat);
        }

        $manager->flush();

        // Articles
        $i = 0;
        foreach ($articles as $item => $articleTitle) {
            $date = $faker->dateTimeBetween('-6 months', 'now');
            $immutableDate = (new \DateTimeImmutable())->createFromMutable($date);
            $article = new Article();
            $imagesName = $images[$item % count($images)];
            $article
                ->setTitle($articleTitle)
                ->setImage($imagesName)
                ->setSlug($slugger->slugify($articleTitle))
                ->setKeywords($faker->words(5, true))
                ->setDescription($faker->sentence(10))
                ->setContent($content[$item] ?? $faker->paragraphs(3, true))
                ->setIsPublished($faker->boolean(70))
                ->setIsArchived($faker->boolean(10))
                ->setAuthor($admin)
                ->setCategory($faker->randomElement($catArray))
                ->setCreatedAt($immutableDate)
            ;

            $manager->persist($article);
            $this->addReference('ARTICLE_' . $i, $article);

            if ($i % 100 === 0) {
                $manager->flush(); // Article enregistré en base de données tous les 10 articles
            }

            $i++;
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}
