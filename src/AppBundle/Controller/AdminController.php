<?php

namespace AppBundle\Controller;

use PostBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

/**
 * Class AdminController
 */
class AdminController extends BaseAdminController
{
    /**
     * @param object $entity
     */
    public function prePersistEntity($entity)
    {
        if ($entity instanceof Post) {
            $entity->setUser($this->getUser());
        }

        parent::prePersistEntity($entity); // TODO: Change the autogenerated stub
    }

}
