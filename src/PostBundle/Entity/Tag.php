<?php

namespace PostBundle\Entity;

use AppBundle\Utils\Helper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tag
 *
 * @ORM\Table(name="sb_tags")
 * @ORM\Entity(repositoryClass="PostBundle\Repository\TagRepository")
 */
class Tag
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
     * @ORM\Column(name="name", type="string", length=30)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug_name", type="string", length=30, nullable=true)
     */
    private $slugName;

    /**
     * @ORM\ManyToMany(targetEntity="Post", mappedBy="tags")
     * @ORM\JoinTable(
     *     name="posts_tags",
     *     joinColumns={
     *          @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     *     }
     * )
     */
    private $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function __toString()
    {
        return (string)$this->getName();
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
     * Set name.
     *
     * @param string $name
     *
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->setSlugName();

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
     * Set slugName.
     *
     * @param string $slugName
     *
     * @return Tag
     */
    public function setSlugName()
    {
        $this->slugName = Helper::url_slug($this->getName(), ['transliterate' => true]);

        return $this;
    }

    /**
     * Get slugName.
     *
     * @return string
     */
    public function getSlugName()
    {
        return $this->slugName;
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
        $post->addTag($this);
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
        $post->removeTag($this);
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
