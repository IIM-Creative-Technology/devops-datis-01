<?php

namespace App\Controller;

use App\Entity\Posts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/index.html.twig", name="index.html.twig")
     */
    public function index()
    {
        $date = new \DateTime('2018-11-19');

        $post = new Posts();
        $post->setDateCreated($date);

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}
