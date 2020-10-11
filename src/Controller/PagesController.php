<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Posts;
use App\Form\ContactType;
use App\Repository\PagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagesController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @Route("/home", name="home", methods="GET")
     *
     * @return Response
     */
    public function index()
    {
        return $this->redirectToRoute('home_posts', ['posts_page' => 1]);
    }

    /**
     * @Route("/about", name="about", methods="GET")
     *
     * @param PagesRepository $pagesRepository
     *
     * @return Response
     */
    public function about(PagesRepository $pagesRepository): Response
    {
        return $this->render('pages/about.html.twig', ['page' => $pagesRepository->findOneBy(['type' => 'about'])]);
    }

    /**
     * @Route("/contact", name="contact", methods="GET|POST")
     *
     * @param PagesRepository $pagesRepository
     * @param Request         $request
     *
     * @return Response
     */
    public function contact(PagesRepository $pagesRepository, Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $this->addFlash(
                'notice',
                'Your message was sent!'
            );

            return $this->redirectToRoute('contact');
        }

        return $this->render('pages/contact.html.twig', [
            'page' => $pagesRepository->findOneBy(['type' => 'contact']),
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/read/{id}", name="posts_read", methods="GET")
     *
     * @param Posts $post
     *
     * @return Response
     */
    public function read(Posts $post): Response
    {
        return $this->render('pages/read.html.twig', ['post' => $post]);
    }

    /**
     * @Route("/home/{posts_page}", name="home_posts", methods="GET")
     *
     * @param $posts_page
     * @param PagesRepository $pagesRepository
     *
     * @return Response
     */
    public function paginate($posts_page, PagesRepository $pagesRepository): Response
    {
        if ($posts_page < 1) {
            return $this->redirectToRoute('home_posts', ['posts_page' => 1]);
        }

        $nbPerPage = 5;

        $postsList = $this->getDoctrine()
            ->getManager()
            ->getRepository('App:Posts')
            ->getPosts($posts_page, $nbPerPage)
        ;

        $nbPages = ceil(count($postsList) / $nbPerPage);

        if ($posts_page > $nbPages) {
            return $this->redirectToRoute('home_posts', ['posts_page' => $nbPages]);
        }

        return $this->render('pages/home.html.twig', [
            'page' => $pagesRepository->findOneBy(['type' => 'home']),
            'postsList' => $postsList,
            'nbPages' => $nbPages,
            'posts_page' => $posts_page,
        ]);
    }
}
