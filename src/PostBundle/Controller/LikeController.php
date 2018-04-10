<?php

namespace PostBundle\Controller;

use PostBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class LikeController extends Controller
{
    /**
     * @Route("/like/post/{id}")
     * @Method("POST")
     *
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function like(Post $post)
    {
        $em = $this->getDoctrine()->getManager();

        if (!$post->getUsersLikes()->contains($this->getUser())) {
            $post->addUsersLike($this->getUser());
            $like_flag = true;
        }
        else {
            $post->removeUsersLike($this->getUser());
            $like_flag = false;
        }

        $em->persist($post);
        $em->flush();

        return $this->json([
            'status' => 'success',
            'like_flag' => $like_flag,
        ]);
    }
}
