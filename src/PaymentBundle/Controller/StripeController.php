<?php

/**
 * @author Tilek
 */
namespace PaymentBundle\Controller;

use PaymentBundle\Entity\Card;
use PaymentBundle\StripeCreator;
use PostBundle\Entity\Book;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use PaymentBundle\CreatorPayment;

/**
 * Class StripeController
 */
class StripeController extends Controller
{
    /**
     * @Route("/stripe/create", name="stripe_create")
     *
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

        $em = $this->getDoctrine()->getManager();
        $customerRepo = $em->getRepository('PaymentBundle:Customer');
        $cardRepo = $em->getRepository('PaymentBundle:Card');

        $customer = $customerRepo->findOneBy(['email' => $data['stripeEmail']]);

        if ($customer) {
            $customer = $stripeInstance->getCustomerById($customer->getStripeId());
        } else {
            $customer = $stripeInstance->getNewCustomer($data['stripeEmail'], $data['stripeToken']);
            $newCustomer = new \PaymentBundle\Entity\Customer();
            $newCustomer->setStripeId($customer->id);
            $newCustomer->setEmail($customer->email);
            $newCustomer->setUser($this->getUser());
            foreach ($customer->sources->data as $card) {
                $cardExist = $cardRepo->findOneBy(['cardId' => $card->id]);
                if (!$cardExist) {
                    $newCard = new Card();
                    $newCard->setCardId($card->id);
                    $newCard->setCustomer($newCustomer);
                    $newCustomer->addCard($newCard);
                    $em->persist($newCard);
                }
            }
            $em->persist($newCustomer);
            $em->flush();
        }

        $charge = $stripeInstance->getNewCharge($customer, $data['amount'] * 100);

//        $product = $stripeInstance->getNewProduct($data['name'], 'service');

//        $plan = $stripeInstance->getNewPlan($product->id, $product->name, $data['amount'] * 100);

//        $subscription = $stripeInstance->getNewSubscription($customer, $plan);



        $charges = $stripeInstance->getAllChargesByCustomerId($customer->id);

        dd($customer);

        dd($charge);
    }

    /**
     * @Route("/stripe")
     *
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
        $catRepo = $em->getRepository('PostBundle:Category');
        $tagRepo = $em->getRepository('PostBundle:Tag');
        $bookRepo = $em->getRepository('PostBundle:Book');

        $bigTag = $tagRepo->findBigTag();

        return $this->render('PaymentBundle:stripe:form.html.twig', [
            'csrf_token' => $csrfToken,
            'categories' => $catRepo->getParentCatsR(),
            'tags' => $tagRepo->findAll(),
            'book' => $bookRepo->find(1),
            'bigTag' => $bigTag['counts'],
            'stripe' => $stripe,
        ]);
    }
}
