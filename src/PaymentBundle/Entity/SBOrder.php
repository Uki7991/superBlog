<?php

namespace PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PaymentBundle\Entity\Customer;

/**
 * SBOrder
 *
 * @ORM\Table(name="sb_orders")
 * @ORM\Entity(repositoryClass="PaymentBundle\Repository\SBOrderRepository")
 */
class SBOrder
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="PaymentBundle\Entity\Customer", inversedBy="orders")
     *
     * @var Customer
     */
    private $customer;

    /**
     * @ORM\OneToOne(targetEntity="PaymentBundle\Entity\Transaction", inversedBy="order")
     *
     * @var Transaction
     */
    private $transaction;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set customer.
     *
     * @param \PaymentBundle\Entity\Customer|null $customer
     *
     * @return SBOrder
     */
    public function setCustomer(\PaymentBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer.
     *
     * @return \PaymentBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set transaction.
     *
     * @param \PaymentBundle\Entity\Transaction|null $transaction
     *
     * @return SBOrder
     */
    public function setTransaction(\PaymentBundle\Entity\Transaction $transaction = null)
    {
        $this->transaction = $transaction;

        return $this;
    }

    /**
     * Get transaction.
     *
     * @return \PaymentBundle\Entity\Transaction|null
     */
    public function getTransaction()
    {
        return $this->transaction;
    }
}
