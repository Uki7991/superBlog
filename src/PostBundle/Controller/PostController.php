<?php
/**
 * Created by PhpStorm.
 * User: kubanov
 * Date: 3/22/18
 * Time: 4:55 PM
 */

namespace PostBundle\Controller;


use PostBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\User;

class PostController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
//        $post = new Post();
//        $user = new User();
//
//        $post->setTitle('hello');
//
//        $user->addPost($post);
//        $user->addPost($post);
//        dd($user);
        return $this->render('PostBundle:Default:index.html.twig');

    }

}