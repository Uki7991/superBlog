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

        $catComs = new Category();
        $catComs->setName('Computers');

        $catPro = new Category();
        $catPro->setName('Programming');

        $catAnim = new Category();
        $catAnim->setName('Animals');

        $catPeople = new Category();
        $catPeople->setName('People');

        $manager->persist($categorySport);
        $manager->persist($categoryEarth);
        $manager->persist($catComs);
        $manager->persist($catPeople);
        $manager->persist($catPro);
        $manager->persist($catAnim);

        $manager->flush();

        $this->addReference('category-earth', $categoryEarth);
        $this->addReference('category-sport', $categorySport);
        $this->addReference('category-computers', $catComs);
        $this->addReference('category-programming', $catPro);
        $this->addReference('category-people', $catPeople);
        $this->addReference('category-animals', $catAnim);
    }

    public function getOrder()
    {
        return 1;
    }

}