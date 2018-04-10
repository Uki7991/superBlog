<?php

namespace PostBundle\Controller;

use PostBundle\Entity\Comment;
use PostBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class LikeController extends Controller
{
    /**
     * @Route("/like/post/{id}")
     *
     * @Method("POST")
     *
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function likePost(Post $post)
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

    /**
     * @Route("/like/comment/{id}")
     *
     * @Method("POST")
     *
     * @param Comment $comment
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function likeComment(Comment $comment)
    {
        $em = $this->getDoctrine()->getManager();

        if (!$comment->getUsersLikes()->contains($this->getUser())) {
            $comment->addUsersLike($this->getUser());
            $like_flag = true;
        }
        else {
            $comment->removeUsersLike($this->getUser());
            $like_flag = false;
        }

        $em->persist($comment);
        $em->flush();

        return $this->json([
            'status' => 'success',
            'like_flag' => $like_flag,
        ]);
    }
}
