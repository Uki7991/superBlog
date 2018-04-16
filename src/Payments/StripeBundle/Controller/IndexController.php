<?php

namespace StripeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
        $stripe = array(
            "secret_key"      => "sk_test_hiOrp6IhITvHJDFlfmWqMBy0",
            "publishable_key" => "pk_test_AAdi3Gu0N2JmXHz39Lww0buh"
        );

        Stripe::setApiKey($stripe['secret_key']);

        $token = $request->request->get('stripeToken');
        $email = $request->request->get('stripeEmail');

        $customer = Customer::create(array(
            'email' => $email,
            'source'  => $token
        ));

        $product = \Stripe\Product::create([
            'name' => 'My SaaS Platform',
            'type' => 'service',
        ]);

        $plan = \Stripe\Plan::create([
            'product' => $product->id,
            'nickname' => $product->name,
            'interval' => 'month',
            'currency' => 'usd',
            'amount' => 10000,
        ]);

        $subscription = \Stripe\Subscription::create([
            'customer' => $customer->id,
            'items' => [['plan' => $plan->id]],
        ]);

        $charge = Charge::create(array(
            'customer' => $customer->id,
            'amount'   => 5000,
            'currency' => 'usd'
        ));

        $chargeNew = new \StripeBundle\Entity\Charge();
        $chargeNew->setStripeId($charge->id);
        $chargeNew->setAmount($charge->amount);
        $chargeNew->setBalanceTransaction($charge->balance_transaction);
        $chargeNew->setCustomer($charge->customer);
        $chargeNew->setStatus($charge->status);
        $chargeNew->setCreatedAt(date('Y-m-d H:i:s', $charge->created));

        dd($chargeNew);
    }

    /**
     * @Route("/stripe")
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form()
    {
        $stripe = array(
            "secret_key"      => "sk_test_hiOrp6IhITvHJDFlfmWqMBy0",
            "publishable_key" => "pk_test_AAdi3Gu0N2JmXHz39Lww0buh"
        );

        Stripe::setApiKey($stripe['secret_key']);

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
