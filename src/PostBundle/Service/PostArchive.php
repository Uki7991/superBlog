<?php
/**
 * Created by PhpStorm.
 * User: kubanov
 * Date: 4/12/18
 * Time: 5:12 PM
 */

namespace PostBundle\Service;

use Doctrine\ORM\EntityManager;
use PostBundle\Entity\Post;

class PostArchive
{
    private $em;
    private $postRepo;

    public function __construct(EntityManager $manager)
    {
        $this->em = $manager;
        $this->postRepo = $this->em->getRepository(Post::class);
    }

    public function archive(Post $post)
    {
        $post = $this->postRepo->find($post);
    }

    /**
     * @param $days
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @return bool
     */
    public function archiveMany($days)
    {
        /**
         * @var Post $post
         */
        $posts = $this->postRepo->getOldPostsByDays($days);

        if ($posts) {
            foreach ($posts as $post) {
                $post->setIsActive(false);
                $this->em->persist($post);
            }
            $this->em->flush();
            return true;
        }

        return false;
    }
}