<?php

namespace PostBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use PostBundle\Entity\Category;
use PostBundle\Entity\Post;
use PostBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CategoryController
 *
 * @Template()
 */
class CategoryController extends Controller
{
    /**
     * @param Category|null $categoriesShow
     * @param null          $postsShow
     *
     * @return array
     *
     * @Route("/categories", name="categories_index")
     *
     * @Method("GET")
     */
    public function indexAction(Category $categoriesShow = null, $postsShow = null)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryRepository = $em->getRepository('PostBundle:Category');
        $postRepository = $em->getRepository('PostBundle:Post');

        $categories = $categoryRepository->findAll();
        $posts = $postRepository->findAll();

        if ($postsShow && $categoriesShow) {
            $posts = $postsShow;
            $categories = $categoriesShow;

        }

        return[
            'categories' => $categories,
            'posts' => $posts,
        ];
    }

    /**
     * @param Request  $request
     * @param Category $category
     *
     * @return array
     *
     * @Route("/category/{id}", name="categories_show")
     *
     * @Method("GET")
     */
    public function show(Request $request, Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository(Post::class)->findBy(['category' => $category], ['createdAt' => 'DESC']);

        $categoryRepo = $em->getRepository('PostBundle:Category');
        $tagRepo = $em->getRepository('PostBundle:Tag');

        $categories = $categoryRepo->getParentCatsR();
        $tags = $tagRepo->findAll();
        $bigTag = $tagRepo->findBigTag();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return [
            'active' => $category,
            'categories' => $categoryRepo->getParentCatsR(),
            'posts' => $posts,
            'tags' => $tags,
            'bigTag' => $bigTag['counts'],
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route("/category/children/{id}")
     *
     * @Method("GET")
     *
     * @param Category $category
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getChildren(Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $catRepo = $em->getRepository('PostBundle:Category');

        $children = $catRepo->getChildren($category->getId());

        if (!$children) {
            $status = 'noChildren';

            return $this->json([
                'status' => $status,
            ]);
        }

        $status = 'success';

        return $this->json([
            'status' => $status,
            'children' => $children,
        ]);
    }

    /**
     * @param Request $request
     *
     * @Route("/categories/create", name="create_category_with_posts")
     *
     * @Method({"GET", "POST"})
     *
     * @return Response
     */
    public function createCategoryWithPosts(Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $tagRepo = $em->getRepository('PostBundle:Tag');
        $catRepo = $em->getRepository('PostBundle:Category');

        $tags = $tagRepo->findAll();
        $categories = $catRepo->getParentCatsR();
        $bigTag = $tagRepo->findBigTag();

        $category = new Category();
        $form = $this->createForm('PostBundle\Form\CategoryType', $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($category->getPosts() as $post) {
                $post->setUser($user);
                $post->setCategory($category);
            }

            $em->persist($category);
            $em->flush();
        }

        return $this->render('@Post/category/create.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories,
            'tags' => $tags,
            'bigTag' => $bigTag['counts'],
        ]);
    }
}
