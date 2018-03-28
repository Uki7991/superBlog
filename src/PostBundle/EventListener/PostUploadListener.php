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
use PostBundle\Entity\Post;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class PostUploadListener
{
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($args->getEntity() instanceof Post && $args->hasChangedField('image'))
        {
            if ($args->getNewValue('image')) {
                unlink('uploads/posts/'.$args->getOldValue('image'));
            }
            else {
                $entity->setImage($args->getOldValue('image'));
            }
        }

        $this->uploadFile($entity);
    }

    public function uploadFile($entity)
    {
        if (!$entity instanceof Post)
        {
            return;
        }
        $file = $entity->getImage();

        if (!$file instanceof UploadedFile)
        {
            return;
        }

        $fileName = $this->uploader->upload($file);
        $entity->setImage($fileName);
    }

}