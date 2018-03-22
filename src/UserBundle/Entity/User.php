<?php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use PostBundle\PostBundle;
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
     * @var \PostBundle\Entity\Comment
     *
     * @ORM\OneToMany(targetEntity="PostBundle\Entity\Comment", mappedBy="user")
     */
    protected $comments;

    /**
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
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

    /**
     * Add comment.
     *
     * @param \PostBundle\Entity\Comment $comment
     *
     * @return User
     */
    public function addComment(\PostBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment.
     *
     * @param \PostBundle\Entity\Comment $comment
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeComment(\PostBundle\Entity\Comment $comment)
    {
        return $this->comments->removeElement($comment);
    }

    /**
     * Get comments.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
