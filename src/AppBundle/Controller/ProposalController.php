<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Proposal;
use AppBundle\Service\ConfirmationMail;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ProposalController extends Controller
{
    /**
     * @Route("/proposal")
     *
     * @Method("POST")
     *
     * @param Request $request
     * @param ConfirmationMail $confirmationMail
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function store(Request $request, ConfirmationMail $confirmationMail)
    {
        $message = [
            'status' => 'error',
        ];
        $data = $request->request->all();

        if (!$data) {
            return $this->json($message);
        }

        $em = $this->getDoctrine()->getManager();

        $proposal = new Proposal();
        $proposal->setName($data['name']);
        $proposal->setPhone($data['phone']);

        $em->persist($proposal);
        $em->flush();

        $confirmationMail->confirmAction($proposal, 'tilek.kubanov@gmail.com');

        $message['status'] = 'success';

        return $this->json($message);
    }
}
