<?php

namespace PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="sb_transactions")
 * @ORM\Entity(repositoryClass="PaymentBundle\Repository\TransactionRepository")
 */
class Transaction
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
     * @ORM\ManyToOne(targetEntity="PaymentBundle\Entity\Customer", inversedBy="transactions")
     *
     * @var Customer
     */
    private $customer;

    /**
     * @ORM\OneToOne(targetEntity="PaymentBundle\Entity\SBOrder", inversedBy="transaction")
     *
     * @var SBOrder
     */
    private $order;

    /**
     * @ORM\Column(name="amount", type="float")
     *
     * @var float
     */
    private $amount;

    /**
     * @ORM\Column(name="currency", type="string", length=5)
     *
     * @var string
     */
    private $currency;

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
     * Set amount.
     *
     * @param float $amount
     *
     * @return Transaction
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount.
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set currency.
     *
     * @param string $currency
     *
     * @return Transaction
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency.
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set customer.
     *
     * @param \PaymentBundle\Entity\Customer|null $customer
     *
     * @return Transaction
     */
    public function setCustomer(\PaymentBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer.
     *
     * @return \PaymentBundle\Entity\Customer|null
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set order.
     *
     * @param \PaymentBundle\Entity\SBOrder|null $order
     *
     * @return Transaction
     */
    public function setOrder(\PaymentBundle\Entity\SBOrder $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order.
     *
     * @return \PaymentBundle\Entity\SBOrder|null
     */
    public function getOrder()
    {
        return $this->order;
    }
}
