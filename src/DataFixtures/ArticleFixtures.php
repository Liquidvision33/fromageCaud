<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class ArticleFixtures extends Fixture implements OrderedFixtureInterface
{
    public const ARTICLES = [
        [
            'articleName' => 'Pièce montée fromages 10 pers',
            'articlePicture' => 'traiteur1.jpg',
            'category' => 'Plateau de fromages'
        ],
        [
            'articleName' => 'Plateau de fromages 4 pers',
            'articlePicture' => 'Traiteur3.jpg',
            'category' => 'Plateau de fromages'
        ],
        [
            'articleName' => 'Plateau de charcuteries 8/10 pers',
            'articlePicture' => 'Traiteur5.jpg',
            'category' => 'Plateau de charcuteries'
        ],
        [
            'articleName' => 'Tarte aux fromages et poires 8 pers',
            'articlePicture' => 'Traiteur2.jpg',
            'category' => 'Les cuisinés'
        ],
        [
            'articleName' => 'Bleu de causse',
            'articlePicture' => 'Fromage1.jpg',
            'category' => 'Fromage'
        ],
        [
            'articleName' => 'Tomme de savoie',
            'articlePicture' => 'Fromage2.jpg',
            'category' => 'Fromage'
        ],
        [
            'articleName' => 'Osso Iraty',
            'articlePicture' => 'Fromage3.jpg',
            'category' => 'Fromage'
        ],
        [
            'articleName' => 'Feta',
            'articlePicture' => 'Fromage4.jpg',
            'category' => 'Fromage'
        ],
        [
            'articleName' => 'Montagne Blanc',
            'articlePicture' => 'Vin1.jpg',
            'category' => 'Vin blanc'
        ],
        [
            'articleName' => 'Bandol',
            'articlePicture' => 'Vin2.jpg',
            'category' => 'Vin rosé'
        ],
        [
            'articleName' => 'Coffret dégustation',
            'articlePicture' => 'Vin3.jpg',
            'category' => 'Coffret'
        ],
        [
            'articleName' => 'Cotes de Blaye',
            'articlePicture' => 'Vin5.jpg',
            'category' => 'Vin rouge'
        ],
        [
            'articleName' => 'Croutons',
            'articlePicture' => 'crouton.jpg',
            'category' => 'Le salé'
        ],
        [
            'articleName' => 'Piment',
            'articlePicture' => 'piment.jpg',
            'category' => 'Condiment'
        ],
        [
            'articleName' => 'Yaourt',
            'articlePicture' => 'Epicerie2.jpg',
            'category' => 'Yaourt'
        ],
        [
            'articleName' => 'Biscuits sucré',
            'articlePicture' => 'biscuits.jpg',
            'category' => 'Le sucré'
        ],
        [
            'articleName' => 'Beurre d\'isigny',
            'articlePicture' => 'beurre.jpg',
            'category' => 'Beurre'
        ],
        [
            'articleName' => 'Créme fraiche AOP',
            'articlePicture' => 'creme.jpg',
            'category' => 'Crème fraiche'
        ],
    ];

    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        foreach (self::ARTICLES as $value) {
            $article = new Article();
            $article->setName($value['articleName']);
            $article->setDescription($faker->text(100));
            $article->setArticlePicture($value['articlePicture']);
            $article->setSlug($this->slugger->slug($article->getName())->lower());
            $article->setStock($faker->numberBetween(1, 20));
            $article->setPrice($faker->numberBetween(1500, 9500));

            $category = $this->getReference('category_' . $value['category']);
            $article->setCategory($category);

            $manager->persist($article);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}

