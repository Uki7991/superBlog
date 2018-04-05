<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use UserBundle\Entity\User;
use Google_Client;
use Google_Service_Drive;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserController extends Controller
{
    /**
     * @Route("/profile", name="fos_user_profile_show_over")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profile(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $postRepo = $em->getRepository('PostBundle:Post');
        $user = $this->getUser();
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

    /**
     * @Route("/profile/show/{slug}", name="show_profile_")
     *
     * @param Request $request
     * @param $slug
     *
     * @return Response
     */
    public function showProfile(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $postRepo = $em->getRepository('PostBundle:Post');
        $userRepo = $em->getRepository('UserBundle:User');
        $user = $userRepo->findOneBy(['usernameCanonical' => $slug]);

        if ($user === $this->getUser()) {
            return $this->redirectToRoute('fos_user_profile_show_over');
        }

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

    /**
     * @Route("/api/google", name="apiGoogle")
     *
     * @Method("GET")
     *
     * @throws \Google_Exception
     *
     */
    public function apiGoogle()
    {
        $client = new Google_Client();
        $projectDir = $this->getParameter('kernel.project_dir');
        $client->setAuthConfig($projectDir . '/client_secret.json');
        $client->setAccessType("offline");        // offline access
        $client->setIncludeGrantedScopes(true);   // incremental auth
        $client->addScope(\Google_Service_Plus::USERINFO_EMAIL);
//        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/');
        $client->setRedirectUri('http://super-blog.com/app_dev.php/api/google/auth');
//        oauth2callback.php
        $auth_url = $client->createAuthUrl();

        return $this->redirect($auth_url);
    }

    /**
     * @Route("/api/google/auth")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Google_Exception
     */
    public function apiGoogleAuth(Request $request)
    {
        $client = new Google_Client();
        $projectDir = $this->getParameter('kernel.project_dir');
        $client->setAuthConfig($projectDir . '/client_secret.json');
        $client->addScope(\Google_Service_Plus::USERINFO_EMAIL);
        $client->setRedirectUri('http://super-blog.com/app_dev.php/api/google/auth');

        if ($request->query->get('code')) {
            $client->fetchAccessTokenWithAuthCode($request->query->get('code'));
            $sesion = new Session();
            $sesion->set('access_token', $client->getAccessToken());
            $client->setAccessToken($sesion->get('access_token'));

            $service = new \Google_Service_Plus($client);
            $user = $service->people->get('me');

            return $this->redirectToRoute('apiNewUser', [
                'id' => $user->getId(),
                'username' => $user->getName()->getFamilyName(),
                'email' => $user->getEmails()[0]->getValue(),
            ]);
        }
    }

    /**
     * @Route("/api/new/user", name="apiNewUser")
     *
     * @Method("GET")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newUser(Request $request)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $data = $request->query;

        $user = $userManager->findUserBy(['gId' => $data->get('id')]);
        if (!$user) {
            $user = $userManager->createUser();
            $user->setGId($data->get('id'));
            $user->setUsername($data->get('username'));
            $user->setEmail($data->get('email'));
            $user->setPlainPassword(md5(rand(111111, 999999)));
            $user->setEnabled(true);

            $userManager->updateUser($user, true);
        }

        $token = new UsernamePasswordToken(
            $user,
            $user->getPassword(),
            'secured_area',
            $user->getRoles()
        );

        $this->get('security.token_storage')->setToken($token);

        $request->getSession()->set('_security_secured_area', serialize($token));

//        return $this->redirectToRoute('profile_show', [
//            'slug' => $user->getUsernameCanonical(),
//        ]);
        return $this->redirectToRoute('posts_index');
    }
}
