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
     * @return string
     */
    public function profile(User $user)
    {
        return $this->renderView('@User/user/index.html.twig', [
            'user' => $user,
        ]);
    }
}
