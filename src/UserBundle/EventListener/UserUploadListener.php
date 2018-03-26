<?php
/**
 * Created by PhpStorm.
 * User: kubanov
 * Date: 3/26/18
 * Time: 3:14 PM
 */

namespace UserBundle\EventListener;

use AppBundle\Utils\FileUploader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class UserUploadListener
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

        if ($args->getEntity() instanceof User && $args->hasChangedField('avatar'))
        {
            unlink('uploads/users/'.$args->getOldValue('avatar'));
        }

        $this->uploadFile($entity);
    }

    public function uploadFile($entity)
    {
        if (!$entity instanceof User)
        {
            return;
        }
        $file = $entity->getAvatar();

        if (!$file instanceof UploadedFile)
        {
            return;
        }

        $fileName = $this->uploader->upload($file);
        $entity->setAvatar($fileName);
    }
}