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
    public function store(Request $request, \Swift_Mailer $mailer)
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

        $messageEmail = (new \Swift_Message('Hello Email'))
            ->setFrom('support@superblog.test')
            ->setTo('tilek.kubanov@gmail.com')
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    ':Emails:registration.html.twig',
                    array('name' => $proposal->getName())
                ),
                'text/html'
            );

        $message['status'] = 'success';

        $mailer->send($messageEmail);

        return $this->json($message);
    }
}
