<?php
/**
 * Created by PhpStorm.
 * User: kubanov
 * Date: 4/16/18
 * Time: 12:57 PM
 */

namespace PaymentBundle\Service;

use PaymentBundle\StripeCreator;
use Stripe\Plan;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Subscription;
use Stripe\Product;
use PaymentBundle\SBPayment;

class StripePayment implements SBPayment
{
    /**
     * @param $customer
     * @param $plan
     *
     * @return \Stripe\ApiResource
     */
    public function getNewSubscription($customer, $plan)
    {
        return Subscription::create([
            'customer' => $customer->id,
            'items' => [['plan' => $plan->id]],
        ]);
    }

    /**
     * @param $email
     * @param $token
     *
     * @return \Stripe\ApiResource
     */
    public function getNewCustomer($email, $token)
    {
        return Customer::create(array(
            'email' => $email,
            'source'  => $token
        ));
    }

    /**
     * @param $name
     * @param $type
     *
     * @return \Stripe\ApiResource
     */
    public function getNewProduct($name, $type)
    {
        return Product::create([
            'name' => $name,
            'type' => $type,
        ]);
    }

    /**
     * @param $id
     * @param $name
     * @param $amount
     * @param string $interval
     * @param string $currency
     *
     * @return \Stripe\ApiResource
     */
    public function getNewPlan($id, $name, $amount, $interval = 'month', $currency = 'usd')
    {
        return Plan::create([
            'product' => $id,
            'nickname' => $name,
            'interval' => $interval,
            'currency' => $currency,
            'amount' => $amount,
        ]);
    }

    /**
     * @param $customer
     * @param $amount
     *
     * @return \Stripe\ApiResource
     */
    public function getNewCharge($customer, $amount)
    {
        $charge = \Stripe\Charge::create(array(
            'customer' => $customer->id,
            'amount'   => $amount,
            'currency' => 'usd',
        ));

        return $charge;
    }

    /**
     * @param $secretKey
     * @param $publushableKey
     *
     * @return array
     */
    public function init($secretKey, $publushableKey)
    {
        $stripe = array(
            "secret_key"      => $secretKey,
            "publishable_key" => $publushableKey
        );

        Stripe::setApiKey($stripe['secret_key']);

        return $stripe;
    }

    /**
     * @param $id
     *
     * @return \Stripe\StripeObject
     */
    public function getCustomer($id)
    {
        return Customer::retrieve($id);
    }

    /**
     * @param $id
     *
     * @return \Stripe\Collection
     */
    public function getAllChargesByCustomerId($id)
    {
        return \Stripe\Charge::all(['customer' => $id]);
    }
}