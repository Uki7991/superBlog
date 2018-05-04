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
    public function getNewSubscription($customer, $plan)
    {
        return Subscription::create([
            'customer' => $customer->id,
            'items' => [['plan' => $plan->id]],
        ]);
    }

    public function getNewCustomer($email, $token)
    {
        return Customer::create(array(
            'email' => $email,
            'source'  => $token
        ));
    }

    public function getNewProduct($name, $type)
    {
        return Product::create([
            'name' => $name,
            'type' => $type,
        ]);
    }

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

    public function getNewCharge($customer, $amount)
    {
        $charge = \Stripe\Charge::create(array(
            'customer' => $customer->id,
            'amount'   => $amount,
            'currency' => 'usd',
        ));

        return $charge;
    }

    public function init($secretKey, $publushableKey)
    {
        $stripe = array(
            "secret_key"      => $secretKey,
            "publishable_key" => $publushableKey
        );

        Stripe::setApiKey($stripe['secret_key']);

        return $stripe;
    }

    public function getCustomer($id)
    {
        return Customer::retrieve($id);
    }

    public function getAllChargesByCustomerId($id)
    {
        return \Stripe\Charge::all(['customer' => $id]);
    }
}