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
     * @ORM\ManyToMany(targetEntity="PostBundle\Entity\Post", mappedBy="usersLikes")
     *
     * @var array
     */
    protected $postsLikes;

    /**
     * @ORM\ManyToMany(targetEntity="PostBundle\Entity\Comment", mappedBy="usersLikes")
     *
     * @var array
     */
    protected $commentsLikes;

    /**
     * @var \PostBundle\Entity\Comment
     *
     * @ORM\OneToMany(targetEntity="PostBundle\Entity\Comment", mappedBy="user")
     */
    protected $comments;

    /**
     * @ORM\Column(name="avatar", type="string", length=255, options={"default" = "default_avatar.png"})
     * @Assert\Image()
     * @Assert\File()
     */
    protected $avatar;

    /**
     * @var string
     *
     * @ORM\Column(name="google_id", type="string", length=255, nullable=true, unique=true)
     */
    protected $googleId;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_id", type="string", length=255, nullable=true, unique=true)
     */
    protected $facebookId;

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
        $this->postsLikes = new ArrayCollection();
        $this->commentsLikes = new ArrayCollection();
        $this->setAvatar('default_avatar.png');
    }

    /**
     * Set avatar.
     *
     * @param string $avatar
     *
     * @return User
     */
    public function setAvatar($avatar = 'default_avatar.png')
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
     * @return \PostBundle\Entity\Comment
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set googleId.
     *
     * @param string|null $googleId
     *
     * @return User
     */
    public function setGoogleId($googleId = null)
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * Get googleId.
     *
     * @return string|null
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * Set facebookId.
     *
     * @param string|null $facebookId
     *
     * @return User
     */
    public function setFacebookId($facebookId = null)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get facebookId.
     *
     * @return string|null
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }


    /**
     * Add postsLike.
     *
     * @param \PostBundle\Entity\Post $postsLike
     *
     * @return void
     */
    public function addPostsLike(\PostBundle\Entity\Post $postsLike)
    {
        if ($this->postsLikes->contains($postsLike))
        {
            return;
        }

        $this->postsLikes->add($postsLike);
        $postsLike->addUsersLike($this);
    }

    /**
     * Remove postsLike.
     *
     * @param \PostBundle\Entity\Post $postsLike
     *
     * @return void TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePostsLike(\PostBundle\Entity\Post $postsLike)
    {
        if (!$this->postsLikes->contains($postsLike))
        {
            return;
        }

        $this->postsLikes->removeElement($postsLike);
        $postsLike->removeUsersLike($this);
    }

    /**
     * Get postsLikes.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPostsLikes()
    {
        return $this->postsLikes;
    }

    public function getUserPostsLikesIds()
    {
        $likes = [];
        foreach ($this->getPostsLikes() as $postsLike) {
            $likes[] = $postsLike->getId();
        }

        return $likes;
    }

    /**
     * Add commentsLike.
     *
     * @param \PostBundle\Entity\Comment $commentsLike
     *
     * @return void
     */
    public function addCommentsLike(\PostBundle\Entity\Comment $commentsLike)
    {
        if ($this->commentsLikes->contains($commentsLike)) {
            return;
        }

        $this->commentsLikes->add($commentsLike);
        $commentsLike->addUsersLike($this);
    }

    /**
     * Remove commentsLike.
     *
     * @param \PostBundle\Entity\Comment $commentsLike
     *
     * @return void TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCommentsLike(\PostBundle\Entity\Comment $commentsLike)
    {
        if (!$this->commentsLikes->contains($commentsLike)) {
            return;
        }

        $this->commentsLikes->removeElement($commentsLike);
        $commentsLike->removeUsersLike($this);
    }

    /**
     * Get commentsLikes.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentsLikes()
    {
        return $this->commentsLikes;
    }
}
