<?php

namespace UserBundle\Controller;

use AppBundle\Utils\Helper;
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

/**
 * Class UserController
 */
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

        $csrfToken = $this->get('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        return $this->render('@User/user/index.html.twig', [
            'user' => $user,
            'posts' => $posts,
            'pagination' => $pagination,
            'csrf_token' => $csrfToken,
        ]);
    }

    /**
     * @Route("/profile/show/{slug}", name="show_profile_")
     *
     * @param Request $request
     * @param string  $slug
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
     * @return Response
     */
    public function apiGoogle()
    {
        $client = new Google_Client();
        $projectDir = $this->getParameter('kernel.project_dir');
        $client->setAuthConfig($projectDir.'/client_secret.json');
        $client->setAccessType("offline");        // offline access
        $client->setIncludeGrantedScopes(true);   // incremental auth
        $client->addScope(\Google_Service_Plus::USERINFO_EMAIL);
//        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/');
        $client->setRedirectUri('http://super-blog.com/app_dev.php/api/google/auth');
//        oauth2callback.php
        $authUrl = $client->createAuthUrl();

        return $this->redirect($authUrl);
    }

    /**
     * @Route("/api/google/auth")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @throws \Google_Exception
     */
    public function apiGoogleAuth(Request $request)
    {
        $client = new Google_Client();
        $projectDir = $this->getParameter('kernel.project_dir');
        $client->setAuthConfig($projectDir.'/client_secret.json');
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

        return $this->redirectToRoute('');
    }

    /**
     * @Route("/google/user", name="login_google")
     *
     * @Method("GET")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function googleUser(Request $request)
    {
        $data = $request->query->all();

        $token = $this->loginUser($data, 'googleId');

        $request->getSession()->set('_security_secured_area', serialize($token));

        return $this->json($token);
    }

    /**
     * @Route("/fb/user", name="login_fb")
     *
     * @Method("GET")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function fbUser(Request $request)
    {
        $data = $request->query->all();

        $token = $this->loginUser($data, 'facebookId');

        $request->getSession()->set('_security_secured_area', serialize($token));

        return $this->json($token);
    }

    /**
     * @param array  $data
     * @param string $source
     *
     * @return UsernamePasswordToken
     */
    protected function loginUser(array $data, string $source = null)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->findUserBy([$source => $data['id']]);
        if (!$user) {
            $user = $userManager->createUser();
            $user->setUsername(Helper::urlSlug($data['username'], ['transliterate' => true]));
            $user->setEmail($data['email']);
            $user->setPlainPassword(md5(rand(111111, 999999)));
            $user->setEnabled(true);

            if ('googleId' === $source) {
                $user->setGoogleId($data['id']);
            }
            if ('facebookId' === $source) {
                $user->setFacebookId($data['id']);
            }

            $userManager->updateUser($user, true);
        }

        $token = new UsernamePasswordToken(
            $user,
            $user->getPassword(),
            'secured_area',
            $user->getRoles()
        );

        $this->get('security.token_storage')->setToken($token);

        return $token;
    }
}
