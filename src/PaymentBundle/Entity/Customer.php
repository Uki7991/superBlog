<?php

namespace PaymentBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use UserBundle\Entity\User;

/**
 * Customer
 *
 * @ORM\Table(name="sb_customers")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\CustomerRepository")
 */
class Customer
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
     * @ORM\Column(name="stripe_id", type="string", length=100, nullable=true)
     *
     * @var string
     */
    private $stripeId;

    /**
     * @ORM\Column(name="paypal_id", type="string", length=100, nullable=true)
     *
     * @var string
     */
    private $paypalId;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="customers")
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="PaymentBundle\Entity\SBOrder", mappedBy="customer")
     *
     * @var array
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity="PaymentBundle\Entity\Transaction", mappedBy="customer")
     *
     * @var array
     */
    private $transactions;

    /**
     * @ORM\OneToMany(targetEntity="PaymentBundle\Entity\Card", mappedBy="customer", cascade={"remove"})
     *
     * @var array
     */
    private $cards;

    /**
     * @ORM\Column(name="email", type="string", length=75)
     *
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
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
     * Constructor
     */
    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->transactions = new ArrayCollection();
        $this->cards = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    /**
     * Set stripeId.
     *
     * @param string $stripeId
     *
     * @return Customer
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
     * Set paypalId.
     *
     * @param string $paypalId
     *
     * @return Customer
     */
    public function setPaypalId($paypalId)
    {
        $this->paypalId = $paypalId;

        return $this;
    }

    /**
     * Get paypalId.
     *
     * @return string
     */
    public function getPaypalId()
    {
        return $this->paypalId;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime|null $createdAt
     *
     * @return Customer
     */
    public function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set user.
     *
     * @param \UserBundle\Entity\User|null $user
     *
     * @return Customer
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \UserBundle\Entity\User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add order.
     *
     * @param \PaymentBundle\Entity\SBOrder $order
     *
     * @return Customer
     */
    public function addOrder(\PaymentBundle\Entity\SBOrder $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order.
     *
     * @param \PaymentBundle\Entity\SBOrder $order
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeOrder(\PaymentBundle\Entity\SBOrder $order)
    {
        return $this->orders->removeElement($order);
    }

    /**
     * Get orders.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Add transaction.
     *
     * @param \PaymentBundle\Entity\Transaction $transaction
     *
     * @return Customer
     */
    public function addTransaction(\PaymentBundle\Entity\Transaction $transaction)
    {
        $this->transactions[] = $transaction;

        return $this;
    }

    /**
     * Remove transaction.
     *
     * @param \PaymentBundle\Entity\Transaction $transaction
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeTransaction(\PaymentBundle\Entity\Transaction $transaction)
    {
        return $this->transactions->removeElement($transaction);
    }

    /**
     * Get transactions.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * Add card.
     *
     * @param \PaymentBundle\Entity\Card $card
     *
     * @return Customer
     */
    public function addCard(\PaymentBundle\Entity\Card $card)
    {
        $this->cards[] = $card;

        return $this;
    }

    /**
     * Remove card.
     *
     * @param \PaymentBundle\Entity\Card $card
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCard(\PaymentBundle\Entity\Card $card)
    {
        return $this->cards->removeElement($card);
    }

    /**
     * Get cards.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCards()
    {
        return $this->cards;
    }
}
