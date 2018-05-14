<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

/**
 * Class PostController
 */
class PostController extends FOSRestController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getPostsAction()
    {
        $postRepo = $this->getDoctrine()->getRepository('PostBundle:Post');

        $posts = $postRepo->findAll();

        $view = $this->view($posts, 200);

        return $this->handleView($view);
    }
}
