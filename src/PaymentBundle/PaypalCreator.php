<?php
/**
 * Created by PhpStorm.
 * User: kubanov
 * Date: 4/24/18
 * Time: 11:25 AM
 */

namespace PaymentBundle;


use PaypalBundle\Service\PaypalPayment;

class PaypalCreator implements CreatorPayment
{
    public function factoryMethod()
    {
        return new PaypalPayment();
    }
}