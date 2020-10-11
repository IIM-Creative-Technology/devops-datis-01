<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Posts;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setName('Technology');

        $post = new Posts();
        $post->setTitle('Machine Learning');
        $post->setContent('Content test');
        $post->setDateCreated(new \DateTime());

        $post->setCategory($category);

        $manager->persist($category);
        $manager->persist($post);

        $category = new Category();
        $category->setName('Design');

        $post = new Posts();
        $post->setTitle('WebGL Canvas');
        $post->setContent('Content test');
        $post->setDateCreated(new \DateTime());

        $post->setCategory($category);

        $manager->persist($category);
        $manager->persist($post);

        $category = new Category();
        $category->setName('Science');

        $post = new Posts();
        $post->setTitle('Cellular Bioenergetics');
        $post->setContent('Content test');
        $post->setDateCreated(new \DateTime());

        $post->setCategory($category);

        $manager->persist($category);
        $manager->persist($post);

        $category = new Category();
        $category->setName('Travel');

        $post = new Posts();
        $post->setTitle('25 Places to absolutely see');
        $post->setContent('Content test');
        $post->setDateCreated(new \DateTime());

        $post->setCategory($category);

        $manager->persist($category);
        $manager->persist($post);

        for ($i = 0; $i < 9; ++$i) {
            $post = new Posts();
            $post->setTitle('Article test');
            $post->setContent('Content test');
            $post->setDateCreated(new \DateTime());

            $post->setCategory($category);

            $manager->persist($post);
        }

        $manager->flush();
    }
}
