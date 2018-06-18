<?php
/**
 * Created by PhpStorm.
 * User: kubanov
 * Date: 3/23/18
 * Time: 12:44 PM
 */
namespace PostBundle\EventListener;

use AppBundle\Utils\FileUploader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping\Entity;
use PostBundle\Entity\Post;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class PostUploadListener
 */
class PostUploadListener
{
    private $uploader;

    /**
     * PostUploadListener constructor.
     * @param FileUploader $uploader
     */
    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        /**
         * @var Post $entity
         */
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        /**
         * @var Post $entity
         */
        $entity = $args->getEntity();

        if ($args->getEntity() instanceof Post && $args->hasChangedField('image')) {
            if ($args->getNewValue('image')) {
                unlink('uploads/posts/'.$args->getOldValue('image'));
            } else {
                $entity->setImage($args->getOldValue('image'));
            }
        }

        $this->uploadFile($entity);
    }

    /**
     * @param Post $entity
     */
    public function uploadFile($entity)
    {
        if (!$entity instanceof Post) {
            return;
        }
        $file = $entity->getImage();

        if (!$file instanceof UploadedFile) {
            return;
        }

        $fileName = $this->uploader->upload($file);
        $entity->setImage($fileName);
    }

}