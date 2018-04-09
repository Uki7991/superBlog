<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Proposal;
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
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function store(Request $request)
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

        $message['status'] = 'success';

        return $this->json($message);
    }
}
