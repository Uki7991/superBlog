<?php

namespace PostBundle\Controller;

use Doctrine\ORM\NoResultException;
use PostBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Post controller.
 *
 */
class PostController extends Controller
{
    /**
     * Lists all post entities.
     *
     * @Route("/", name="posts_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $postRepo = $em->getRepository('PostBundle:Post');
        $catRepo = $em->getRepository('PostBundle:Category');
        $tagRepo = $em->getRepository('PostBundle:Tag');

        $posts = $postRepo->findAll([], ['createdAt' => 'DESC']);
        $categories = $catRepo->findAll();
        $tags = $tagRepo->findAll();

        return $this->render('PostBundle:post:index.html.twig', array(
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags,
        ));
    }

    /**
     * Creates a new post entity.
     *
     * @Route("/post/new", name="posts_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        if (!$this->getUser())
        {
            return $this->redirectToRoute('posts_index');
        }
        $post = new Post();
        $form = $this->createForm('PostBundle\Form\PostType', $post);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $catRepo = $em->getRepository('PostBundle:Category');
        $categories = $catRepo->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $post->setUser($this->getUser());
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('posts_show', array('id' => $post->getId(), 'slug' => $post->getSlugTitle()));
        }

        return $this->render('@Post/post/new.html.twig', array(
            'post' => $post,
            'categories' => $categories,
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Post $post
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/post/{id}/{slug}", name="posts_show")
     * @Method("GET")
     */
    public function showAction(Post $post, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $catRepo = $em->getRepository('PostBundle:Category');
        $tagRepo = $em->getRepository('PostBundle:Tag');

        $tags = $tagRepo->findAll();
        $categories = $catRepo->findAll();

        return $this->render('@Post/post/show.html.twig', array(
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags,
        ));
    }

    /**
     * Displays a form to edit an existing post entity.
     *
     * @Route("/post2/{id}/edit", name="posts_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Post $post)
    {
        dd($request->headers->get('referer'));
        $deleteForm = $this->createDeleteForm($post);
        $editForm = $this->createForm('PostBundle\Form\PostType', $post);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('posts_edit', array('id' => $post->getId()));
        }

        return $this->render('post/edit.html.twig', array(
            'post' => $post,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a post entity.
     *
     * @Route("/post/{id}", name="posts_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Post $post)
    {
        $form = $this->createDeleteForm($post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();
        }

        return $this->redirectToRoute('posts_index');
    }

    /**
     * Creates a form to delete a post entity.
     *
     * @param Post $post The post entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Post $post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('posts_delete', array('id' => $post->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
