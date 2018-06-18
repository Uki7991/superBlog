<?php

namespace PostBundle\Repository;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\AbstractQuery;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy([], ['createdAt' => 'DESC']);
    }

    /**
     * @param string $query
     *
     * @return mixed
     */
    public function findApiPosts($query)
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p.title as name')
            ->where('p.title like :title')
            ->setParameter('title', $query.'%')
            ->setMaxResults(8);

        $query = $qb->getQuery();

        return $query->getResult(AbstractQuery::HYDRATE_ARRAY);
    }

    /**
     * @param integer $days
     *
     * @return mixed
     */
    public function getOldPostsByDays($days)
    {
        $date = new \DateTime();
        dump($date);
        try {
            $dateInterval = new \DateInterval("P{$days}D");
        } catch (\Exception $e) {
        }
        $date->sub($dateInterval);
        dump($date);

        $qb = $this->createQueryBuilder('p')
            ->where('p.createdAt < :date')
            ->setParameter('date', $date)
            ->andWhere('p.isActive = true');

        $query = $qb->getQuery();

        return $query->getResult();
    }
}
