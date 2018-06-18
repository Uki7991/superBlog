<?php
/**
 * Created by PhpStorm.
 * User: kubanov
 * Date: 4/24/18
 * Time: 11:25 AM
 */

namespace PaymentBundle;

use PaymentBundle\Service\PaypalPayment;

/**
 * Class PaypalCreator
 */
class PaypalCreator implements CreatorPayment
{
    /**
     * @return mixed|PaypalPayment
     */
    public function factoryMethod()
    {
        return new PaypalPayment();
    }
}