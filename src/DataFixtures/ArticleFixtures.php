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
            'articleName' => 'Pièce montée fromage 10 pers',
            'articlePicture' => 'traiteur1.jpg',
            'category' => 'Traiteur'
        ],
        [
            'articleName' => 'Plateau de fromage 4 pers',
            'articlePicture' => 'Traiteur3.jpg',
            'category' => 'Traiteur'
        ],
        [
            'articleName' => 'Plateau de charcuterie 8/10 pers',
            'articlePicture' => 'Traiteur5.jpg',
            'category' => 'Traiteur'
        ],
        [
            'articleName' => 'Tarte aux fromages et poires 8 pers',
            'articlePicture' => 'Traiteur2.jpg',
            'category' => 'Traiteur'
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
            'category' => 'Vin'
        ],
        [
            'articleName' => 'Bandol',
            'articlePicture' => 'Vin2.jpg',
            'category' => 'Vin'
        ],
        [
            'articleName' => 'Coffret dégustation',
            'articlePicture' => 'Vin3.jpg',
            'category' => 'Vin'
        ],
        [
            'articleName' => 'Cotes de Blaye',
            'articlePicture' => 'Vin5.jpg',
            'category' => 'Vin'
        ],
        [
            'articleName' => 'Croutons',
            'articlePicture' => 'crouton.jpg',
            'category' => 'Epicerie'
        ],
        [
            'articleName' => 'Piment',
            'articlePicture' => 'piment.jpg',
            'category' => 'Epicerie'
        ],
        [
            'articleName' => 'Yaourt',
            'articlePicture' => 'Epicerie2.jpg',
            'category' => 'Epicerie'
        ],
        [
            'articleName' => 'Biscuits salés',
            'articlePicture' => 'biscuits.jpg',
            'category' => 'Epicerie'
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
            $article->setDescription($faker->text(10));
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

