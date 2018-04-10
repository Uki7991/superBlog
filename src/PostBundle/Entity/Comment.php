<?php

namespace PostBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use UserBundle\Entity\User;
use PostBundle\Entity\Post;

/**
 * Comment
 *
 * @ORM\Table(name="sb_comments")
 * @ORM\Entity(repositoryClass="PostBundle\Repository\CommentRepository")
 */
class Comment
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
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     * @Assert\NotBlank()
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", inversedBy="commentsLikes")
     * @ORM\JoinTable(
     *     name="comments_users_likes",
     *     joinColumns={@ORM\JoinColumn(name="comment_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     *
     * @var array
     */
    private $usersLikes;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="PostBundle\Entity\Comment", inversedBy="children", cascade={"remove"})
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     */
    private $parent;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="PostBundle\Entity\Comment", mappedBy="parent", cascade={"remove"})
     */
    private $children;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     * @Assert\NotBlank()
     */
    private $createdAt;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->children = new ArrayCollection();
        $this->usersLikes = new ArrayCollection();
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
     * Set comment.
     *
     * @param string $comment
     *
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment.
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Comment
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
     * Set user.
     *
     * @param \UserBundle\Entity\User|null $user
     *
     * @return Comment
     */
    public function setUser(User $user = null)
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
     * Set post.
     *
     * @param \PostBundle\Entity\Post|null $post
     *
     * @return Comment
     */
    public function setPost(Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post.
     *
     * @return \PostBundle\Entity\Post|null
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set name.
     *
     * @param string|null $name
     *
     * @return Comment
     */
    public function setName($name = null)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add child.
     *
     * @param \PostBundle\Entity\Comment $child
     *
     * @return Comment
     */
    public function addChild(\PostBundle\Entity\Comment $child)
    {
        $child->setParent($this);
        $this->children[] = $child;


        return $this;
    }

    /**
     * Remove child.
     *
     * @param \PostBundle\Entity\Comment $child
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeChild(\PostBundle\Entity\Comment $child)
    {
        return $this->children->removeElement($child);
    }

    /**
     * Get children.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent.
     *
     * @param \PostBundle\Entity\Comment|null $parent
     *
     * @return Comment
     */
    public function setParent(\PostBundle\Entity\Comment $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent.
     *
     * @return int
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add usersLike.
     *
     * @param \UserBundle\Entity\User $usersLike
     *
     * @return void
     */
    public function addUsersLike(\UserBundle\Entity\User $usersLike)
    {
        if ($this->usersLikes->contains($usersLike)) {
            return;
        }

        $this->usersLikes->add($usersLike);
        $usersLike->addCommentsLike($this);
    }

    /**
     * Remove usersLike.
     *
     * @param \UserBundle\Entity\User $usersLike
     *
     * @return void TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeUsersLike(\UserBundle\Entity\User $usersLike)
    {
        if (!$this->usersLikes->contains($usersLike)) {
            return;
        }

        $this->usersLikes->removeElement($usersLike);
        $usersLike->removeCommentsLike($this);
    }

    /**
     * Get usersLikes.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsersLikes()
    {
        return $this->usersLikes;
    }
}
