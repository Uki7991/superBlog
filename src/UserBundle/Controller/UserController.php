<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Entity\User;

class UserController extends Controller
{
    /**
     * @Route("/profile/{id}", name="profile")
     * @param User $user
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profile(User $user)
    {
        return $this->render('@User/user/index.html.twig', [
            'user' => $user,
        ]);
    }
}
