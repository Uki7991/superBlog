<?php

namespace PostBundle\Controller;

use PostBundle\Entity\Comment;
use PostBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{
    /**
     *
     */
    public function index() {

    }

    /**
     * @Route("/comment/store/{post}", name="comment_new")
     * @Method("POST")
     * @param Request $request
     * @param $post
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function store(Request $request, Post $post) {
        dd($request->request);
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        if ($user) {
            $request->request->set('name', $user->getUsername());
        }
        $comment = new Comment();
        $comment->setName($request->request->get('name'));
        $comment->setUser($user);
        $comment->setComment($request->request->get('comment'));
        $comment->setPost($post);
        if ($request->request->get('parent')) {
            $parent = $em->getRepository('PostBundle:Comment')->find($request->request->get('parent'));
            $parent->addChild($comment);
        }



        $em->persist($comment);
        $em->flush();

        $url = $request->headers->get('referer');

        return $this->redirect($url);
    }
}
