<?php

namespace UserBundle\Controller;

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
    public function profile($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $postRepo = $em->getRepository('PostBundle:Post');
        $userRepo = $em->getRepository('UserBundle:User');
        $user = $userRepo->findOneBy(['usernameCanonical' => $slug]);
        $posts = $postRepo->findBy(['user' => $user], ['createdAt' => 'DESC']);

        return $this->render('@User/user/index.html.twig', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }
}
