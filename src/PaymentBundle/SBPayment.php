<?php

namespace PaymentBundle;

/**
 * Interface SBPayment
 */
interface SBPayment
{
    /**
     * @param $secretKey
     * @param $publishableKey
     *
     * @return mixed
     */
    public function init($secretKey, $publishableKey);

    /**
     * @param $customer
     * @param $plan
     *
     * @return mixed
     */
    public function getNewSubscription($customer, $plan);

    /**
     * @param $email
     * @param $token
     *
     * @return mixed
     */
    public function getNewCustomer($email, $token);

    /**
     * @param $id
     * @param $name
     * @param $amount
     * @param string $interval
     * @param string $currency
     *
     * @return mixed
     */
    public function getNewPlan($id, $name, $amount, $interval = 'month', $currency = 'usd');
}