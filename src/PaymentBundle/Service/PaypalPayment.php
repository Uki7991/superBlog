<?php
/**
 * Created by PhpStorm.
 * User: kubanov
 * Date: 4/23/18
 * Time: 4:36 PM
 */

namespace PaymentBundle\Service;


use PaymentBundle\SBPayment;

class PaypalPayment implements SBPayment
{

    protected $apiContext;

    public function init($secretKey, $publishableKey)
    {
        $apiContext =  new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $publishableKey,     // ClientID
                $secretKey     // ClientSecret
            )
        );

        $apiContext->setConfig([
            'mode' => 'sandbox'
        ]);

        $this->apiContext = $apiContext;

        return $apiContext;
    }

    public function getNewSubscription($customer, $plan)
    {
        // TODO: Implement getNewSubscription() method.
    }

    public function getNewCustomer($email, $token)
    {
        // TODO: Implement getNewCustomer() method.
    }

    public function getNewPlan($id, $name, $amount, $interval = 'month', $currency = 'usd')
    {
        // TODO: Implement getNewPlan() method.
    }

    public function getNewPayment()
    {
        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($this->getNewPayer())
            ->setRedirectUrls($this->getNewRedirectUrls())
            ->setTransactions(array($this->getNewTransaction(1.00, 'USD')));

        return $payment;
    }

    public function getNewAmount($totalSum, $currency)
    {
        $amount = new \PayPal\Api\Amount();
        $amount->setTotal($totalSum);
        $amount->setCurrency($currency);

        return $amount;
    }

    public function getNewTransaction($totalSum, $currency)
    {
        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($this->getNewAmount($totalSum, $currency));

        return $transaction;
    }

    public function getNewPayer()
    {
        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        return $payer;
    }

    public function getNewRedirectUrls()
    {
        $redirectUrls = new \PayPal\Api\RedirectUrls();

        $redirectUrls->setReturnUrl('https://superblog.test/paypal/success')
            ->setCancelUrl('https://superblog.test/paypal/cancel');

        return $redirectUrls;
    }
}