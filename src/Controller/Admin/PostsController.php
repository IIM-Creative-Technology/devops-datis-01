<?php

namespace App\Controller\Admin;

use App\Entity\Posts;
use App\Form\PostsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/posts")
 */
class PostsController extends AbstractController
{
    /**
     * @Route("/page/{page}", name="posts_index", methods="GET")
     *
     * @param $page
     *
     * @return Response
     */
    public function paginate($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException('La page '.$page." n'existe pas.");
        }

        $nbPerPage = 5;

        $postsList = $this->getDoctrine()
            ->getManager()
            ->getRepository('App:Posts')
            ->getPosts($page, $nbPerPage)
        ;

        $nbPages = ceil(count($postsList) / $nbPerPage);

        if ($page > $nbPages) {
            throw $this->createNotFoundException('La page '.$page." n'existe pas.");
        }

        return $this->render('admin/posts/index.html.twig', [
            'postsList' => $postsList,
            'nbPages' => $nbPages,
            'page' => $page,
        ]);
    }

    /**
     * @Route("/", name="admin_index", methods="GET")
     *
     * @return Response
     */
    public function index()
    {
        return $this->redirectToRoute('posts_index', ['page' => 1]);
    }

    /**
     * @Route("/new", name="posts_new", methods="GET|POST")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $post = new Posts();
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash(
                'success',
                'New post created!'
            );

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/posts/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="posts_show", methods="GET")
     *
     * @param Posts $post
     *
     * @return Response
     */
    public function show(Posts $post): Response
    {
        return $this->render('admin/posts/show.html.twig', ['post' => $post]);
    }

    /**
     * @Route("/{id}/edit", name="posts_edit", methods="GET|POST")
     *
     * @param Request $request
     * @param Posts   $post
     *
     * @return Response
     */
    public function edit(Request $request, Posts $post): Response
    {
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Post was updated!'
            );

            return $this->redirectToRoute('posts_edit', ['id' => $post->getId()]);
        }

        return $this->render('admin/posts/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="posts_delete", methods="DELETE")
     *
     * @param Request $request
     * @param Posts   $post
     *
     * @return Response
     */
    public function delete(Request $request, Posts $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();

            $this->addFlash(
                'deleted',
                'Post deleted'
            );
        }

        return $this->redirectToRoute('admin_index');
    }
}
