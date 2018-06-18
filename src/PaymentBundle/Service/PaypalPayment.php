<?php
/**
 * Created by PhpStorm.
 * User: kubanov
 * Date: 4/23/18
 * Time: 4:36 PM
 */

namespace PaymentBundle\Service;


use PaymentBundle\SBPayment;
use Stripe\Customer;
use Stripe\Plan;

/**
 * Class PaypalPayment
 */
class PaypalPayment implements SBPayment
{

    protected $apiContext;

    /**
     * @param string $secretKey
     * @param string $publishableKey
     *
     * @return \PayPal\Rest\ApiContext
     */
    public function init($secretKey, $publishableKey)
    {
        $apiContext =  new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $publishableKey,     // ClientID
                $secretKey     // ClientSecret
            )
        );

        $apiContext->setConfig([
            'mode' => 'sandbox',
        ]);

        $this->apiContext = $apiContext;

        return $apiContext;
    }

    /**
     * @param $customer
     * @param $plan
     */
    public function getNewSubscription($customer, $plan)
    {
        // TODO: Implement getNewSubscription() method.
    }

    /**
     * @param $email
     * @param $token
     */
    public function getNewCustomer($email, $token)
    {
        // TODO: Implement getNewCustomer() method.
    }

    /**
     * @param $id
     * @param $name
     * @param $amount
     * @param string $interval
     * @param string $currency
     */
    public function getNewPlan($id, $name, $amount, $interval = 'month', $currency = 'usd')
    {
        // TODO: Implement getNewPlan() method.
    }

    /**
     * @return \PayPal\Api\Payment
     */
    public function getNewPayment()
    {
        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($this->getNewPayer())
            ->setRedirectUrls($this->getNewRedirectUrls())
            ->setTransactions(array($this->getNewTransaction(1.00, 'USD')));

        return $payment;
    }

    /**
     * @param $totalSum
     * @param $currency
     *
     * @return \PayPal\Api\Amount
     */
    public function getNewAmount($totalSum, $currency)
    {
        $amount = new \PayPal\Api\Amount();
        $amount->setTotal($totalSum);
        $amount->setCurrency($currency);

        return $amount;
    }

    /**
     * @param $totalSum
     * @param $currency
     *
     * @return \PayPal\Api\Transaction
     */
    public function getNewTransaction($totalSum, $currency)
    {
        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($this->getNewAmount($totalSum, $currency));

        return $transaction;
    }

    /**
     * @return \PayPal\Api\Payer
     */
    public function getNewPayer()
    {
        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        return $payer;
    }

    /**
     * @return \PayPal\Api\RedirectUrls
     */
    public function getNewRedirectUrls()
    {
        $redirectUrls = new \PayPal\Api\RedirectUrls();

        $redirectUrls->setReturnUrl('https://superblog.test/paypal/success')
            ->setCancelUrl('https://superblog.test/paypal/cancel');

        return $redirectUrls;
    }
}