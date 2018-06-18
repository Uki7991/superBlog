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
use Doctrine\ORM\Mapping\Entity;
use UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class UserUploadListener
 */
class UserUploadListener
{
    private $uploader;

    /**
     * UserUploadListener constructor.
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
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($args->getEntity() instanceof User && $args->hasChangedField('avatar')) {
            unlink('uploads/users/'.$args->getOldValue('avatar'));
        }

        $this->uploadFile($entity);
    }

    /**
     * @param $entity
     */
    public function uploadFile($entity)
    {
        if (!$entity instanceof User) {
            return;
        }
        $file = $entity->getAvatar();

        if (!$file instanceof UploadedFile) {
            return;
        }

        $fileName = $this->uploader->upload($file);
        $entity->setAvatar($fileName);
    }
}