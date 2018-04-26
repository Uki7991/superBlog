<?php
/**
 * Created by PhpStorm.
 * User: kubanov
 * Date: 4/16/18
 * Time: 2:42 PM
 */

namespace PaymentBundle;


use PaymentBundle\Service\StripePayment;

class StripeCreator implements CreatorPayment
{

    public function factoryMethod()
    {
        return new StripePayment();
    }
}