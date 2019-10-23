<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $i = 0;
        $categories = [];
        while ($i < 10) {
            $category = new Category();
            $category->setName('Catégorie ' . $i);

            $manager->persist($category);
            $categories[] = $category;
            $i++;
        }

        $manager->flush();

        $i = 0;
        while ($i < 100) {
            $post = new Post();
            $post->setTitle(sprintf('Titre de mon article %s', $i))
                ->setBody('Corps de mon article')
                ->setIsPublished($i%2)
                ->setCategory($categories[$i/10]);

            $manager->persist($post);
            $i++;
        }

        $manager->flush();
    }
}
