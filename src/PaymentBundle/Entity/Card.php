<?php

namespace PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Card
 *
 * @ORM\Table(name="sb_card")
 * @ORM\Entity(repositoryClass="PaymentBundle\Repository\CardRepository")
 */
class Card
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
     * @var string
     *
     * @ORM\Column(name="card_id", type="string")
     */
    private $cardId;

    /**
     * @var string
     *
     * @ORM\Column(name="brand", type="string", nullable=true)
     */
    private $brand;

    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="PaymentBundle\Entity\Customer", inversedBy="cardId")
     */
    private $customer;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=true)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="exp_month", type="integer", nullable=true)
     */
    private $expMonth;

    /**
     * @var int
     *
     * @ORM\Column(name="exp_year", type="integer", nullable=true)
     */
    private $expYear;

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
     * Set cardId.
     *
     * @param string $cardId
     *
     * @return Card
     */
    public function setCardId($cardId)
    {
        $this->cardId = $cardId;

        return $this;
    }

    /**
     * Get cardId.
     *
     * @return string
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * Set brand.
     *
     * @param string $brand
     *
     * @return Card
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand.
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Card
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set expMonth.
     *
     * @param int $expMonth
     *
     * @return Card
     */
    public function setExpMonth($expMonth)
    {
        $this->expMonth = $expMonth;

        return $this;
    }

    /**
     * Get expMonth.
     *
     * @return int
     */
    public function getExpMonth()
    {
        return $this->expMonth;
    }

    /**
     * Set expYear.
     *
     * @param int $expYear
     *
     * @return Card
     */
    public function setExpYear($expYear)
    {
        $this->expYear = $expYear;

        return $this;
    }

    /**
     * Get expYear.
     *
     * @return int
     */
    public function getExpYear()
    {
        return $this->expYear;
    }

    /**
     * Set customerId.
     *
     * @param \PaymentBundle\Entity\Customer|null $customer
     *
     * @return Card
     */
    public function setCustomer(\PaymentBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customerId.
     *
     * @return \PaymentBundle\Entity\Customer|null
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
