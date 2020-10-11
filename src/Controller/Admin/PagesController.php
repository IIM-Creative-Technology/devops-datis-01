<?php

namespace App\Controller\Admin;

use App\Entity\Pages;
use App\Form\PagesType;
use App\Repository\PagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/pages")
 */
class PagesController extends AbstractController
{
    /**
     * @Route("/", name="pages_index", methods="GET")
     *
     * @param PagesRepository $pagesRepository
     *
     * @return Response
     */
    public function index(PagesRepository $pagesRepository): Response
    {
        return $this->render('admin/pages/index.html.twig', ['pages' => $pagesRepository->findAll()]);
    }

    /**
     * @Route("/{type}/edit", name="pages_edit", methods="GET|POST")
     *
     * @param Request $request
     * @param Pages   $page
     *
     * @return Response
     */
    public function edit(Request $request, Pages $page): Response
    {
        $form = $this->createForm(PagesType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Page was updated'
            );

            return $this->redirectToRoute('pages_edit', ['type' => $page->getType()]);
        }

        return $this->render('admin/pages/edit.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }
}
