<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture implements OrderedFixtureInterface
{
    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
        $parent = $this->createCategory('Crémerie', null, $manager);

        $this->createCategory('Fromage', $parent, $manager);
        $this->createCategory('Beurre', $parent, $manager);
        $this->createCategory('Yaourt', $parent, $manager);
        $this->createCategory('Crème fraiche', $parent, $manager);

        $parent = $this->createCategory('Traiteur', null, $manager);

        $this->createCategory('Plateaux de charcuteries', $parent, $manager);
        $this->createCategory('Plateaux de fromages', $parent, $manager);
        $this->createCategory('Les cuisinés', $parent, $manager);

        $parent = $this->createCategory('Cave', null, $manager);

        $this->createCategory('Vin blanc', $parent, $manager);
        $this->createCategory('Vin rouge', $parent, $manager);
        $this->createCategory('Vin rosé', $parent, $manager);
        $this->createCategory('Coffrets', $parent, $manager);

        $parent = $this->createCategory('Epicerie', null, $manager);

        $this->createCategory('Le sucré', $parent, $manager);
        $this->createCategory('Le salé', $parent, $manager);
        $this->createCategory('Condiments', $parent, $manager);

        $manager->flush();
    }

    public function createCategory(string $name, Category $parent = null, ObjectManager $manager)
    {
        $category = new Category();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $manager->persist($category);
        $this->addReference('category_' . $name, $category);

        return $category;
    }
    public function getOrder()
    {
        return 1;
    }
}
