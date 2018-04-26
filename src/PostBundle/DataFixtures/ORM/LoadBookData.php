<?php
/**
 * Created by PhpStorm.
 * User: kubanov
 * Date: 3/23/18
 * Time: 2:13 PM
 */

namespace PostBundle\DataFixtures\ORM;


use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PostBundle\Entity\Book;
use PostBundle\Entity\Category;

class LoadBookData extends AbstractFixture implements ORMFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $bookEarth = new Book();
        $bookEarth->setTitle('Earth');
        $bookEarth->setAuthor(' ');
        $bookEarth->setPrice(21);

        $bookSport = new Book();
        $bookSport->setTitle('Sport');
        $bookEarth->setAuthor(' ');
        $bookEarth->setPrice(21);

        $manager->persist($bookEarth);
        $manager->persist($bookSport);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }

}