<?php

/**
 * @author Tilek.kubanov@gmail.com
 */
namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

            $userActions = $this->get('user.actions');
            $successfullyRegistered = $userActions->register($params["email"], $params["userName"], $params["password"]);

            $params = $successfullyRegistered + $params;
        }
        $view = $this->view($params, 200);

        return $this->handleView($view);
    }

    /**
     * @param Request $request
     *
     * @Rest\Route("/users/login")
     *
     * @return Response
     */
    public function postUsersLoginAction(Request $request)
    {
        $params = [];

        if ($content = $request->getContent()) {
            $params = json_decode($content, true);

            $userActions = $this->get('user.actions');
            $successfullyLogin = $userActions->loginAction($request, $params['userName'], $params['password']);

            $params = $successfullyLogin + $params;
        }
        $view = $this->view($params, 200);

        return $this->handleView($view);
    }
}
