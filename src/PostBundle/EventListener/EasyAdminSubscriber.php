<?php
/**
 * Created by PhpStorm.
 * User: kubanov
 * Date: 3/23/18
 * Time: 6:27 PM
 */

namespace PostBundle\EventListener;


use PostBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class EasyAdminSubscriber extends Controller implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array('easy_admin.pre_persist' => 'setUserToPost');
    }

    public function setUserToPost(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if (!($entity instanceof Post))
        {
            return;
        }

        $entity->setUser($this->getUser());
    }

}