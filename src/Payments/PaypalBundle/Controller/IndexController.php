<?php

namespace PaypalBundle\Controller;

use PaymentBundle\PaypalCreator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{
    /**
     * @Route("/paypal")
     * @Method("GET")
     */
    public function index()
    {
        $csrfToken = $this->get('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $em = $this->getDoctrine()->getManager();
        $postRepo = $em->getRepository('PostBundle:Post');
        $catRepo = $em->getRepository('PostBundle:Category');
        $tagRepo = $em->getRepository('PostBundle:Tag');

        $posts = $postRepo->findAll([], ['createdAt' => 'DESC']);
        $bigTag = $tagRepo->findBigTag();

        return $this->render('@Paypal/form.html.twig', [
            'csrf_token' => $csrfToken,
            'categories' => $catRepo->getParentCatsR(),
            'tags' => $tagRepo->findAll(),
            'bigTag' => $bigTag['counts'],
        ]);
    }

    /**
     * @Route("/paypal")
     * @Method("POST")
     */
    public function create()
    {
        $secretKey = $this->getParameter('payment.paypal.clientSecret');
        $publishableKey = $this->getParameter('payment.paypal.clientId');

        $paypal = new PaypalCreator();

        $apiContext = $paypal->factoryMethod()->init($secretKey, $publishableKey);


        $payment = $paypal->factoryMethod()->getNewPayment();
        $paymentID = $payment;

//        dd($this->json($paymentID));

        return $this->json($paymentID);
    }

    /**
     * @Route("/paypal/pay")
     * @Method("POST")
     *
     * @param Request $request
     */
    public function pay(Request $request)
    {
        dd($request);
    }
}
