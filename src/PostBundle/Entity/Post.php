<?php

namespace PostBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Utils\Helper;
use Symfony\Component\Validator\Constraints as Assert;
use UserBundle\Entity\User;
use PostBundle\Entity\Category;

/**
 * Post
 *
 * @ORM\Table(name="sb_posts")
 * @ORM\Entity(repositoryClass="PostBundle\Repository\PostRepository")
 */
class Post
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
     * @ORM\OneToMany(targetEntity="PostBundle\Entity\Image", mappedBy="post", cascade={"remove"})
     */
    private $slides;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post", cascade={"remove"})
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="posts")
     * @ORM\JoinTable(
     *     name="posts_tags",
     *     joinColumns={
     *          @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     *     }
     * )
     */
    private $tags;

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\Ip", inversedBy="posts")
     * @ORM\JoinTable(
     *     name="ips_posts",
     *     joinColumns={
     *          @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="ip_id", referencedColumnName="id")
     *     }
     * )
     */
    private $ips;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="posts", cascade={"remove"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $user;

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", inversedBy="postsLikes")
     * @ORM\JoinTable(
     *     name="posts_users_like",
     *     joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     */
    private $usersLikes;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="posts")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=150)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug_title", type="string", length=1550, nullable=true)
     */
    private $slugTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
//     * @Assert\Image()
//     * @Assert\File()
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="blockquote", type="text")
     */
    private $blockquote;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var int
     *
     * @ORM\Column(name="popularity", type="integer", nullable=true)
     */
    private $popularity;

    /**
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt($this->getCreatedAt());
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->ips = new ArrayCollection();
        $this->slides = new ArrayCollection();
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
     * Set title.
     *
     * @param string $title
     *
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->setSlugTitle();

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slugTitle.
     *
     * @return Post
     */
    public function setSlugTitle()
    {
        $this->slugTitle = Helper::url_slug($this->getTitle(), ['transliterate' => true]);
        
        return $this;
    }

    /**
     * Get slugTitle.
     *
     * @return string
     */
    public function getSlugTitle()
    {
        return $this->slugTitle;
    }

    /**
     * Set image.
     *
     * @param string $image
     *
     * @return Post
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image.
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set blockquote.
     *
     * @param string $blockquote
     *
     * @return Post
     */
    public function setBlockquote($blockquote)
    {
        $this->blockquote = $blockquote;

        return $this;
    }

    /**
     * Get blockquote.
     *
     * @return string
     */
    public function getBlockquote()
    {
        return $this->blockquote;
    }

    /**
     * Set content.
     *
     * @param string $content
     *
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set popularity.
     *
     * @param int $popularity
     *
     * @return Post
     */
    public function setPopularity($popularity)
    {
        $this->popularity = $popularity;

        return $this;
    }

    /**
     * Get popularity.
     *
     * @return int
     */
    public function getPopularity()
    {
        return $this->popularity;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Post
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
     * @return Post
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
     * Set user.
     *
     * @param \UserBundle\Entity\User|null $user
     *
     * @return Post
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
     * Set category.
     *
     * @param \PostBundle\Entity\Category|null $category
     *
     * @return Post
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category.
     *
     * @return \PostBundle\Entity\Category|null
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add comment.
     *
     * @param \PostBundle\Entity\Comment $comment
     *
     * @return Post
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

    /**
     * Add tag.
     *
     * @param \PostBundle\Entity\Tag $tag
     *
     */
    public function addTag(\PostBundle\Entity\Tag $tag)
    {
        if ($this->tags->contains($tag))
        {
            return;
        }

        $this->tags->add($tag);
        $tag->addPost($this);
    }

    /**
     * Remove tag.
     *
     * @param \PostBundle\Entity\Tag $tag
     *
     */
    public function removeTag(\PostBundle\Entity\Tag $tag)
    {
        if (!$this->tags->contains($tag))
        {
            return;
        }

        $this->tags->removeElement($tag);
        $tag->removePost($this);
    }

    /**
     * Get tags.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add ip.
     *
     * @param \UserBundle\Entity\Ip $ip
     */
    public function addIp(\UserBundle\Entity\Ip $ip)
    {
        if ($this->ips->contains($ip))
        {
            return;
        }

        $this->ips->add($ip);
        $ip->addPost($this);
    }

    /**
     * Remove ip.
     *
     * @param \UserBundle\Entity\Ip $ip
     *
     */
    public function removeIp(\UserBundle\Entity\Ip $ip)
    {
        if (!$this->ips->contains($ip))
        {
            return;
        }

        $this->ips->removeElement($ip);
        $ip->removePost($this);
    }

    /**
     * Get ips.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIps()
    {
        return $this->ips;
    }

    public function __toString()
    {
        return (string)$this->getTitle();
    }

    /**
     * Add slide.
     *
     * @param \PostBundle\Entity\Image $slide
     *
     * @return Post
     */
    public function addSlide(\PostBundle\Entity\Image $slide)
    {
        $this->slides[] = $slide;

        return $this;
    }

    /**
     * Remove slide.
     *
     * @param \PostBundle\Entity\Image $slide
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeSlide(\PostBundle\Entity\Image $slide)
    {
        return $this->slides->removeElement($slide);
    }

    /**
     * Get slides.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSlides()
    {
        return $this->slides;
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
        if ($this->usersLikes->contains($usersLike))
        {
            return;
        }

        $this->usersLikes->add($usersLike);
        $usersLike->addPostsLike($this);
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
        if (!$this->usersLikes->contains($usersLike)){
            return;
        }

        $this->usersLikes->removeElement($usersLike);
        $usersLike->removePostsLike($this);
    }

    /**
     * Get usersLikes.
     *
     * @return array
     */
    public function getUsersLikes()
    {
        return $this->usersLikes;
    }
}
