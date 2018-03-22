<?php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="sb_users")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \PostBundle\Entity\Post
     *
     * @ORM\OneToMany(targetEntity="PostBundle\Entity\Post", mappedBy="user")
     */
    protected $posts;

    /**
     * @ORM\Column(name="avatar", type="string", length=255)
     * @Assert\Image()
     * @Assert\File()
     */
    protected $avatar;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct()
    {
        parent::__construct();
        $this->posts = new ArrayCollection();
    }

    /**
     * Set avatar.
     *
     * @param string $avatar
     *
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar.
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Add post.
     *
     * @param \PostBundle\Entity\Post $post
     *
     */
    public function addPost(\PostBundle\Entity\Post $post)
    {
        if ($this->posts->contains($post))
        {
            return;
        }

        $this->posts->add($post);

    }

    /**
     * Remove post.
     *
     * @param \PostBundle\Entity\Post $post
     *
     */
    public function removePost(\PostBundle\Entity\Post $post)
    {
        if (!$this->posts->contains($post))
        {
            return;
        }

        $this->posts->removeElement($post);
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
