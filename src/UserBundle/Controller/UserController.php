<?php

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Entity\User;

class UserController extends Controller
{
    /**
     * @Route("/profile/{slug}", name="profile")
     * @param User $user
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profile(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $postRepo = $em->getRepository('PostBundle:Post');
        $userRepo = $em->getRepository('UserBundle:User');
        $user = $userRepo->findOneBy(['usernameCanonical' => $slug]);
        $posts = $postRepo->findBy(['user' => $user], ['createdAt' => 'DESC']);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts,
            $request->request->get('page', 1),
            10
        );

        return $this->render('@User/user/index.html.twig', [
            'user' => $user,
            'posts' => $posts,
            'pagination' => $pagination,
        ]);
    }
}
