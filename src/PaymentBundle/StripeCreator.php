<?php
/**
 * Created by PhpStorm.
 * User: kubanov
 * Date: 4/16/18
 * Time: 2:42 PM
 */

namespace PaymentBundle;

use PaymentBundle\Service\StripePayment;

/**
 * Class StripeCreator
 */
class StripeCreator implements CreatorPayment
{
    /**
     * @return mixed|StripePayment
     */
    public function factoryMethod()
    {
        return new StripePayment();
    }
}