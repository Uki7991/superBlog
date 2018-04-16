<?php

namespace StripeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Charge
 *
 * @ORM\Table(name="sb_charges")
 * @ORM\Entity(repositoryClass="StripeBundle\Repository\ChargeRepository")
 */
class Charge
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
     * @ORM\Column(name="stripe_id", type="string", length=255)
     *
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $stripeId;

    /**
     * @ORM\Column(name="balance_transaction", type="string", length=255)
     *
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $balanceTransaction;

    /**
     * @ORM\Column(name="amount", type="integer")
     *
     * @Assert\NotBlank()
     *
     * @var integer
     */
    private $amount;

    /**
     * @ORM\Column(name="status", type="string", length=50)
     *
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $status;

    /**
     * @ORM\Column(name="customer", type="string", length=255)
     *
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $customer;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     *
     * @var \DateTime
     */
    private $createdAt;

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
     * Set stripeId.
     *
     * @param string $stripeId
     *
     * @return Charge
     */
    public function setStripeId($stripeId)
    {
        $this->stripeId = $stripeId;

        return $this;
    }

    /**
     * Get stripeId.
     *
     * @return string
     */
    public function getStripeId()
    {
        return $this->stripeId;
    }

    /**
     * Set balanceTransaction.
     *
     * @param string $balanceTransaction
     *
     * @return Charge
     */
    public function setBalanceTransaction($balanceTransaction)
    {
        $this->balanceTransaction = $balanceTransaction;

        return $this;
    }

    /**
     * Get balanceTransaction.
     *
     * @return string
     */
    public function getBalanceTransaction()
    {
        return $this->balanceTransaction;
    }

    /**
     * Set amount.
     *
     * @param int $amount
     *
     * @return Charge
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount.
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set status.
     *
     * @param string $status
     *
     * @return Charge
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set customer.
     *
     * @param string $customer
     *
     * @return Charge
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer.
     *
     * @return string
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Charge
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
