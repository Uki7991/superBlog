<?php

namespace PostBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class CategoryController
 * @package PostBundle\Controller
 * @Template()
 */
class CategoryController extends Controller
{
    /**
     * @return array
     * @Route("/categories", name="categories_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categoryRepository = $em->getRepository('PostBundle:Category');
        $postRepository = $em->getRepository('PostBundle:Post');

        $categories = $categoryRepository->findAll();
        $posts = $postRepository->findAll();

        return[
            'categories' => $categories,
            'posts' => $posts,
        ];
    }
}
