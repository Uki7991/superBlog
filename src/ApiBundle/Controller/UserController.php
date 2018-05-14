<?php

/**
 * @author Tilek.kubanov@gmail.com
 */
namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\UserBundle\Model\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 */
class UserController extends FOSRestController
{
    /**
     * @return void
     */
    public function getUsersAction()
    {
        return;
    }

    /**
     * @param string $slug
     *
     * @return mixed
     */
    public function getUserAction($slug)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->findUserBy(['usernameCanonical' => $slug]);

        $view = $this->view($user, 200);

        return $this->handleView($view);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postUsersAction(Request $request)
    {
        $params = [];

        if ($content = $request->getContent()) {
            $params = json_decode($content, true);
        }
        $view = $this->view($content, 200);

        return $this->handleView($view);
    }

}
