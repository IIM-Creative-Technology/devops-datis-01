<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/messages")
 */
class MessagesController extends AbstractController
{
    /**
     * @Route("/", name="messages", methods="GET")
     *
     * @param ContactRepository $contactRepository
     * @return Response
     */
    public function index(ContactRepository $contactRepository): Response
    {
        return $this->render('admin/messages/index.html.twig', ['messages' => $contactRepository->findAll()]);
    }

    /**
     * @Route("/{id}", name="read_message", methods="GET")
     *
     * @param Contact $contact
     * @return Response
     */
    public function read(Contact $contact): Response
    {
        return $this->render('admin/messages/read.html.twig', ['message' => $contact]);
    }
}
