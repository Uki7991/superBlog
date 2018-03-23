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
use PostBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture implements ORMFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $categoryEarth = new Category();
        $categoryEarth->setName('Earth');

        $categorySport = new Category();
        $categorySport->setName('Sport');

        $manager->persist($categorySport);
        $manager->persist($categoryEarth);

        $manager->flush();

        $this->addReference('category-earth', $categoryEarth);
        $this->addReference('category-sport', $categorySport);
    }

    public function getOrder()
    {
        return 2;
    }

}