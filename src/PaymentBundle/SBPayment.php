<?php

namespace PaymentBundle;

interface SBPayment
{
    public function init($secretKey, $publishableKey);

    public function getNewSubscription($customer, $plan);

    public function getNewCustomer($email, $token);

    public function getNewPlan($id, $name, $amount, $interval = 'month', $currency = 'usd');
}