<?php

/**
 * @author Tilek.kubanov@gmail.com
 */
namespace PostBundle\Controller;

use Gregwar\Image\Image as ImageCreator;
use PostBundle\Entity\Image;
use PostBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Ip;

/**
 * Post controller.
 *
 */
class PostController extends Controller
{
    /**
     * Lists all post entities.
     * @param Request $request
     *
     * @Route("/", name="posts_index")
     *
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
//        $session = new Session();
//        $countPost = $session->get('count_post');
//
//        if (!isset($countPost)) {
//            $session->set('count_post', 3);
//        }

        $em = $this->getDoctrine()->getManager();
        $postRepo = $em->getRepository('PostBundle:Post');
        $catRepo = $em->getRepository('PostBundle:Category');
        $tagRepo = $em->getRepository('PostBundle:Tag');

        $posts = $postRepo->findAll([], ['createdAt' => 'DESC']);
        $bigTag = $tagRepo->findBigTag();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            4/*limit per page*/
        );

        $csrfToken = $this->get('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        return $this->render('PostBundle:post:index.html.twig', array(
            'posts' => $posts,
            'categories' => $catRepo->getParentCatsR(),
            'tags' => $tagRepo->findAll(),
            'bigTag' => $bigTag['counts'],
            'pagination' => $pagination,
            'csrf_token' => $csrfToken,
        ));
    }

    /**
     * Creates a new post entity.
     *
     * @param Request $request
     *
     * @Route("/post/new", name="posts_new")
     *
     * @Method({"GET", "POST"})
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function newAction(Request $request)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('posts_index');
        }
        $post = new Post();
        $form = $this->createForm('PostBundle\Form\PostType', $post);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $tagRepo = $em->getRepository('PostBundle:Tag');
        $catRepo = $em->getRepository('PostBundle:Category');

        $tags = $tagRepo->findAll();
        $categories = $catRepo->getParentCatsR();


        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->request->get('tags')) {
                foreach ($request->request->get('tags') as $tag) {
                    $criteria = ['name' => $tag];
                    $tag = $tagRepo->findTagOrCreate($criteria);
                    $post->addTag($tag);
                    $em->persist($tag);
                }
            }

            if ($request->files->get('slides')) {
                foreach ($request->files->get('slides') as $slide) {
                    /**
                     * @var UploadedFile $slide
                     */

                    $fileName = md5(uniqid()).'.'.$slide->guessExtension();

                    ImageCreator::open($slide->getPathname())->cropResize(755, 755)->save('uploads/images/medium/' . $fileName);
                    ImageCreator::open($slide->getPathname())->cropResize(100, 100)->save('uploads/images/small/' . $fileName);
                    ImageCreator::open($slide->getPathname())->save('uploads/images/large/' . $fileName);

                    $slide = new Image();
                    $slide->setImgPath($fileName);
                    $slide->setPost($post);

                    $em->persist($slide);
                }
            }

            $post->setCategory($catRepo->find($request->request->get('category')));
            $post->setUser($this->getUser());
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('posts_show', array('id' => $post->getId(), 'slug' => $post->getSlugTitle()));
        }

        return $this->render('@Post/post/new.html.twig', array(
            'post' => $post,
            'tags' => $tags,
            'categories' => $categories,
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Post $post
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/post/{id}/{slug}", name="posts_show")
     *
     * @Method("GET")
     */
    public function showAction(Post $post)
    {
//        $session = new Session();
//        $countPost = $session->get('count_post');
//
//        if ($countPost === 0) {
//            $session;
//            return $this->redirect('/stripe');
//        }
//        if ($countPost != 0) {
//            $countPost--;
//            $session->set('count_post', $countPost);
//        }

        $em = $this->getDoctrine()->getManager();
        $catRepo = $em->getRepository('PostBundle:Category');
        $tagRepo = $em->getRepository('PostBundle:Tag');
        $commRepo = $em->getRepository('PostBundle:Comment');
        $ipRepo = $em->getRepository('UserBundle:Ip');

        $ip = $ipRepo->findOneBy(['ip' => $_SERVER['REMOTE_ADDR']]);

        if (!$ip) {
            $ip = new Ip();
            $ip->setIp($_SERVER['REMOTE_ADDR']);
            $em->persist($ip);
        }
        if (!$post->getIps()->contains($ip)) {
            $post->addIp($ip);
            $em->persist($post);
            $em->flush();
        }

        $tags = $tagRepo->findAll();
        $categories = $catRepo->getParentCatsR();
        $bigTag = $tagRepo->findBigTag();
        $comms = $commRepo->findBy([
            'post' => $post,
            'parent' => null,
        ]);

        $csrfToken = $this->get('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        return $this->render('@Post/post/show.html.twig', array(
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags,
            'bigTag' => $bigTag['counts'],
            'comments' => $comms,
            'csrf_token' => $csrfToken,
        ));
    }

    /**
     * @param Request $request
     * @param Post    $post
     *
     * Displays a form to edit an existing post entity.
     *
     * @Route("/post2/{id}/edit", name="posts_edit")
     *
     * @Method({"GET", "POST"})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, Post $post)
    {
        $em = $this->getDoctrine()->getManager();
        $tagRepo = $em->getRepository('PostBundle:Tag');
        $catRepo = $em->getRepository('PostBundle:Category');

        $deleteForm = $this->createDeleteForm($post);
        $editForm = $this->createForm('PostBundle\Form\PostType', $post);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            foreach ($request->request->get('tags') as $tag) {
                $criteria = ['name' => $tag];
                $tag = $tagRepo->findTagOrCreate($criteria);
                $post->addTag($tag);
                $em->persist($tag);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('posts_show', array('id' => $post->getId(), 'slug' => $post->getSlugTitle()));
        }

        return $this->render('@Post/post/edit.html.twig', array(
            'post' => $post,
            'categories' => $catRepo->findAll(),
            'tags' => $tagRepo->findAll(),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a post entity.
     *
     * @param Request $request
     * @param Post    $post
     *
     * @Route("/post/{id}", name="posts_delete")
     *
     * @Method("DELETE")
     *
     * @return Response
     */
    public function deleteAction(Request $request, Post $post)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('posts_index');
    }

    /**
     * Creates a form to delete a post entity.
     *
     * @param Post $post The post entity
     *
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
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
