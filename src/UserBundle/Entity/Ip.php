<?php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ip
 *
 * @ORM\Table(name="sb_ips")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\IpRepository")
 */
class Ip
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
     * @ORM\ManyToMany(targetEntity="PostBundle\Entity\Post", mappedBy="ips")
     */
    private $posts;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\Ip(version="4")
     */
    private $ip;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     *
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     *
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $updatedAt;

    /**
     * Ip constructor.
     */
    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt($this->getCreatedAt());
        $this->posts = new ArrayCollection();
    }

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
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Ip
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

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return Ip
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set ip.
     *
     * @param string $ip
     *
     * @return Ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip.
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Add post.
     *
     * @param \PostBundle\Entity\Post $post
     *
     */
    public function addPost(\PostBundle\Entity\Post $post)
    {
        if ($this->posts->contains($post)) {
            return;
        }

        $this->posts->add($post);
        $post->addIp($this);
    }

    /**
     * Remove post.
     *
     * @param \PostBundle\Entity\Post $post
     *
     */
    public function removePost(\PostBundle\Entity\Post $post)
    {
        if (!$this->posts->contains($post)) {
            return;
        }

        $this->posts->removeElement($post);
        $post->removeIp($this);
    }

    /**
     * Get posts.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }
}
