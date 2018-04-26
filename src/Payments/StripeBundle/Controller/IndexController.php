<?php

namespace StripeBundle\Controller;

use PaymentBundle\StripeCreator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use PaymentBundle\CreatorPayment;

class IndexController extends Controller
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

        $secretKey = $this->getParameter('payment.stripe.secretkey');
        $publishableKey = $this->getParameter('payment.stripe.publishablekey');

        $stripe->factoryMethod()->init($secretKey, $publishableKey);

        $data = $request->request->all();

        $customer = $stripe->factoryMethod()->getNewCustomer($data['stripeEmail'], $data['stripeToken']);

        $product = $stripe->factoryMethod()->getNewProduct('BlogSubscription', 'service');

        $plan = $stripe->factoryMethod()->getNewPlan($product->id, $product->name, '5000');

        $subscription = $stripe->factoryMethod()->getNewSubscription($customer, $plan);

        dd($subscription);
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

        return $this->render('@Stripe/form.html.twig', [
            'csrf_token' => $csrfToken,
            'categories' => $catRepo->getParentCatsR(),
            'tags' => $tagRepo->findAll(),
            'bigTag' => $bigTag['counts'],
            'stripe' => $stripe,
        ]);
    }
}
