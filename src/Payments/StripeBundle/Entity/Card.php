<?php

namespace StripeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Card
 *
 * @ORM\Table(name="sb_stripe_cards")
 * @ORM\Entity(repositoryClass="StripeBundle\Repository\CardRepository")
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
     * @ORM\Column(name="stripe_card_id", type="string", length=255)
     *
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $stripeCardId;

    /**
     * @ORM\Column(name="brand", type="string", length=50)
     *
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $brand;

    /**
     * @ORM\Column(name="country", type="string", length=5)
     *
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $country;

    /**
     * @ORM\Column(name="email", type="string", length=100)
     *
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     *
     * @Assert\NotBlank()
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
     * Set stripeCardId.
     *
     * @param string $stripeCardId
     *
     * @return Card
     */
    public function setStripeCardId($stripeCardId)
    {
        $this->stripeCardId = $stripeCardId;

        return $this;
    }

    /**
     * Get stripeCardId.
     *
     * @return string
     */
    public function getStripeCardId()
    {
        return $this->stripeCardId;
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
     * Set country.
     *
     * @param string $country
     *
     * @return Card
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country.
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Card
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
     * @param \DateTime $createdAt
     *
     * @return Card
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
