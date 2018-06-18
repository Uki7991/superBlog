<?php

namespace PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="sb_images")
 * @ORM\Entity(repositoryClass="PostBundle\Repository\ImageRepository")
 */
class Image
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
     * @ORM\Column(name="img_path", type="string", length=60, nullable=true)
     */
    private $imgPath;

    /**
     * @ORM\ManyToOne(targetEntity="PostBundle\Entity\Post", inversedBy="slides")
     * @ORM\JoinColumn(referencedColumnName="id", name="post_id", nullable=true)
     */
    private $post;

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
     * Set imgPath.
     *
     * @param string|null $imgPath
     *
     * @return Image
     */
    public function setImgPath($imgPath = null)
    {
        $this->imgPath = $imgPath;

        return $this;
    }

    /**
     * Get imgPath.
     *
     * @return string|null
     */
    public function getImgPath()
    {
        return $this->imgPath;
    }

    /**
     * Set post.
     *
     * @param \PostBundle\Entity\Post|null $post
     *
     * @return Image
     */
    public function setPost(\PostBundle\Entity\Post $post = null)
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
}
