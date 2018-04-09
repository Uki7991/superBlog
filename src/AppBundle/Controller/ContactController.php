<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ContactController extends Controller
{
    /**
     * @Route("/contacts", name="contacts")
     *
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $contactRepo = $em->getRepository('AppBundle:Contact');

        $contact = $contactRepo->find(1);

        return $this->render(':default:contacts.html.twig', [
            'contact' => $contact,
            'categories' => null,
            'tags' => null,
        ]);
    }
}
