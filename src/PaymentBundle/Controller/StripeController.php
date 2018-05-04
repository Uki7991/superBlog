<?php

namespace PaymentBundle\Controller;

use PaymentBundle\StripeCreator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use PaymentBundle\CreatorPayment;

class StripeController extends Controller
{
    /**
     * @Route("/stripe/create", name="stripe_create")
     * @Method("POST")
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        $stripe = new StripeCreator();

        $stripeInstance = $stripe->factoryMethod();

        $secretKey = $this->getParameter('payment.stripe.secretkey');
        $publishableKey = $this->getParameter('payment.stripe.publishablekey');

        $stripeInstance->init($secretKey, $publishableKey);

        $data = $request->request->all();

        $customer = $stripeInstance->getNewCustomer($data['stripeEmail'], $data['stripeToken']);

        $charge = $stripeInstance->getNewCharge($customer, $data['amount'] * 100);

//        $product = $stripeInstance->getNewProduct($data['name'], 'service');

//        $plan = $stripeInstance->getNewPlan($product->id, $product->name, $data['amount'] * 100);

//        $subscription = $stripeInstance->getNewSubscription($customer, $plan);

        $customer = $stripeInstance->getCustomer($customer->id);

        $charges = $stripeInstance->getAllChargesByCustomerId($customer->id);

        dd($customer);

        dd($charge);
    }

    /**
     * @Route("/stripe")
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form()
    {
        $stripe = new StripeCreator();

        $secretKey = $this->getParameter('payment.stripe.secretkey');
        $publishableKey = $this->getParameter('payment.stripe.publishablekey');

        $stripe = $stripe->factoryMethod()->init($secretKey, $publishableKey);

        $csrfToken = $this->get('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $em = $this->getDoctrine()->getManager();
        $postRepo = $em->getRepository('PostBundle:Post');
        $catRepo = $em->getRepository('PostBundle:Category');
        $tagRepo = $em->getRepository('PostBundle:Tag');

        $posts = $postRepo->findAll([], ['createdAt' => 'DESC']);
        $bigTag = $tagRepo->findBigTag();

        return $this->render('PaymentBundle:stripe:form.html.twig', [
            'csrf_token' => $csrfToken,
            'categories' => $catRepo->getParentCatsR(),
            'tags' => $tagRepo->findAll(),
            'bigTag' => $bigTag['counts'],
            'stripe' => $stripe,
        ]);
    }
}
