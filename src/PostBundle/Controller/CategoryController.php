<?php

namespace PostBundle\Controller;

use PostBundle\Entity\Category;
use PostBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoryController
 * @package PostBundle\Controller
 * @Template()
 */
class CategoryController extends Controller
{
    /**
     * @param Category|null $categoriesShow
     * @param null $postsShow
     * @return array
     * @Route("/categories", name="categories_index")
     * @Method("GET")
     */
    public function indexAction(Category $categoriesShow = null, $postsShow = null)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryRepository = $em->getRepository('PostBundle:Category');
        $postRepository = $em->getRepository('PostBundle:Post');

        $categories = $categoryRepository->findAll();
        $posts = $postRepository->findAll();

        if ($postsShow && $categoriesShow)
        {
            $posts = $postsShow;
            $categories = $categoriesShow;

        }

        return[
            'categories' => $categories,
            'posts' => $posts,
        ];
    }

    /**
     * @param Category $category
     * @return array
     *
     * @Route("/category/{id}", name="categories_show")
     * @Method("GET")
     */
    public function show(Request $request, Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository(Post::class)->findBy(['category' => $category], ['createdAt' => 'DESC']);
        
        $categoryRepo = $em->getRepository('PostBundle:Category');
        $tagRepo = $em->getRepository('PostBundle:Tag');

        $categories = $categoryRepo->findAll();
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
            'categories' => $categories,
            'posts' => $posts,
            'tags' => $tags,
            'bigTag' => $bigTag['counts'],
            'pagination' => $pagination
        ];
    }
}
