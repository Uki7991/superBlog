<?php

namespace PostBundle\Controller;

use PostBundle\Entity\Comment;
use PostBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * CommentController
 *
 * @Configuration\Route("/comment")
 */
class CommentController extends Controller
{
    /**
     *
     */
    public function index() {

    }

    /**
     * @Configuration\Route("/store/{post}", name="comment_new")
     * @Configuration\Method("POST")
     *
     * @param Request $request
     * @param $post
     *
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

    /**
     * @Configuration\Route("/store/create/{post}", name="api_comment_new")
     * @Configuration\Method("POST")
     * @Configuration\Template
     *
     * @param Request $request
     * @param Post $post
     *
     * @return array | string
     */
    public function createAction(Request $request, Post $post)
    {
        $data = $request->request->all();

        $em = $this->getDoctrine()->getManager();
        $commRepo = $em->getRepository('PostBundle:Comment');

        $comment = new Comment();
        $comment->setName($data['name']);
        $comment->setComment($data['comment']);
        $comment->setPost($post);

        if ($this->getUser()) {
            $comment->setUser($this->getUser());
        }

        $parent = $commRepo->find($data['reply']);
        if ($parent) {
            $comment->setParent($parent);
        }

        $validator = $this->get('validator');
        $errors = $validator->validate($comment);

        if (count($errors) > 0) {
            $status = ['status' => 'error', 'message' => $errors];
            return $this->json($status, 400);
        }

        try {
            $em->persist($comment);
            $em->flush();
            $data['comment_id'] = $comment->getId();
        } catch (\Exception $e) {
            $status = ['status' => 'error', 'message' => $e->getMessage()];
            return $this->json($status, 400);
        }

        return ['comment' => $comment];

//        return $this->json($status);
    }
}
