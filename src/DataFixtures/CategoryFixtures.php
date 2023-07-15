<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{

    public function __construct(private SluggerInterface $slugger){}

    public function createCategory(string $categoryName, Category $parent = null, ObjectManager $manager)
    {
        $category = new Category();
        $category->setName($categoryName);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $manager->persist($category);
        $this->addReference('category_' . $categoryName, $category);

        return $category;
    }

    public function load(ObjectManager $manager): void
    {
        $parent = $this->createCategory('Fromage', null, $manager);

        $this->createCategory('Traiteur', $parent, $manager);
        $this->createCategory('Vin', $parent, $manager);
        $this->createCategory('Epicerie', $parent, $manager);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
