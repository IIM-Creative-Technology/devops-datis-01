<?php

namespace App\DataFixtures;

use App\Entity\Pages;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PagesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //Home
        $page = new Pages();
        $page->setType('home');
        $page->setTitle('Home');
        $page->setDescription('Welcome to the home page !');
        $page->setDateCreated(new \DateTime());

        $manager->persist($page);

        //Contact
        $page = new Pages();
        $page->setType('contact');
        $page->setTitle('Contact');
        $page->setDescription('Please fill this form if you want to contact us');
        $page->setDateCreated(new \DateTime());

        $manager->persist($page);

        //About
        $page = new Pages();
        $page->setType('about');
        $page->setTitle('About');
        $page->setDescription('This is what we do');
        $page->setDateCreated(new \DateTime());

        $manager->persist($page);



        $manager->flush();
    }
}
