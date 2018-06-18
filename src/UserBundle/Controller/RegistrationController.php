<?php

/**
 * @author Tilek.kubanov@gmail.com
 */
namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class RegistrationController
 */
class RegistrationController extends Controller
{
    const SUCCESS = 'success';

    /**
     * @Route("/registration")
     *
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function registration(Request $request)
    {
        $logger = $this->get('logger');

        $session = $this->get('session');
        $step = $session->get('step');
        $logger->info('step: '.$step);
        if (! isset($step)) {
            $session->set('step', 1);
            $logger->info('Setting step: '.$step);
        }
        $user = $this->get('fos_user.user_manager')->createUser();
        $form = $this->createForm('UserBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (3 === $step) {
                $data = $session->all();
                $user = $this->get('user.actions')->register($data['email'], $data['username'], $data['password'], $data['firstName'], $data['secondName'], $data['country'], 'default_avatar.png');
                if ($user) {
                    $successLogin = $this->get('user.actions')->loginAction($request, $data['username'], $data['password']);
                    if (self::SUCCESS === $successLogin['status']) {
                        $session->clear();

                        return $this->redirect('/');
                        exit;
                    }
                }
            }

            if ($step = $session->get('step')) {
                if (1 === $step) {
                    $session->set('username', $user->getUsername());
                    $session->set('password', $user->getPlainPassword());
                    $session->set('email', $user->getEmail());
                } elseif (2 === $step) {
                    $session->set('firstName', $user->getFirstName());
                    $session->set('secondName', $user->getSecondName());
                    $session->set('country', $user->getCountry());
                }
                $session->set('step', ++$step);
                $logger->info('Setting step++: '.$step);
                $logger->info('Step: '.$step.'/nUser: '.$user);
            }
        }

        $csrfToken = $this->get('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;


        return $this->render('@User/user/register.html.twig', [
            'step' => $step,
            'form' => $form->createView(),
            'csrf_token' => $csrfToken,
        ]);
    }
}
