<?php
/**
 * Created by PhpStorm.
 * User: kubanov
 * Date: 3/23/18
 * Time: 2:08 PM
 */

namespace PostBundle\DataFixtures\ORM;


use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PostBundle\Entity\Post;

class LoadPostData extends AbstractFixture implements ORMFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $postEarth = new Post();
        $postEarth->setTitle('2017 Was One of the Hottest Years on Record. And That Was Without El Niño.');
        $postEarth->setBlockquote('<p class="card-text mt-4">The world in 2017 saw some of the highest average surface temperatures ever recorded, surprising scientists who had expected sharper retreat from recent record years.</p>');
        $postEarth->setContent('<p class="card-text mt-4">The world in 2017 saw some of the highest average surface temperatures ever recorded, surprising scientists who had expected sharper retreat from recent record years.</p><p class="card-text mt-4">Scientists at NASA on Thursday ranked last year as the second-warmest year since reliable record-keeping began in 1880, trailing only 2016. The National Oceanic and Atmospheric Administration, which uses a different analytical method, ranked it third, behind 2016 and 2015.</p><p class="card-text mt-4">What made the numbers unexpected was that last year had no El Niño, a shift in tropical Pacific weather patterns that is usually linked to record-setting heat and that contributed to record highs the previous two years. In fact, last year should have benefited from a weak version of the opposite phenomenon, La Niña, which is generally associated with lower atmospheric temperatures.</p><p class="card-text mt-4">“This is the new normal,” said Gavin A. Schmidt, director of the Goddard Institute for Space Studies, the NASA group that conducted the analysis. But, he said, “It’s also changing. It’s not that we’ve gotten to a new plateau — this isn’t where we’ll stay. In ten years we’re going to say ‘oh look, another record decade of warming temperatures.’”</p><p class="card-text mt-4">An analysis by a private independent group, Berkeley Earth, ranked last year as the warmest year on record without El Niño. Zeke Hausfather, a researcher with the group, said that despite the weak La Niña, “It doesn’t seem like there’s any evidence things are cooling down.”</p><p class="card-text mt-4">By both the NASA and NOAA analyses, 17 of the 18 warmest years since modern record-keeping began have occurred since 2001. Overall, fueled by emissions of carbon dioxide and other greenhouse gases, temperatures have increased more than 1 degree Celsius (1.8 degrees Fahrenheit) since the late 19th century.</p><p class="card-text mt-4">In order to avoid the worst consequences of climate change, scientists say global temperatures must not increase more than 2 degrees Celsius.</p><p class="card-text mt-4">The warming trend comes at a time that President Donald Trump is dialing back many climate-related regulations and policies. Last year he announced that the United States would withdraw from the 2015 Paris climate accord and repeal the Clean Power Plan, an Obama-era measure designed to reduce emissions from power plants.</p><p class="card-text mt-4">But more than statements from politicians or data from scientists, events last year reminded the world that the climate is changing.</p><p class="card-text mt-4">Temperatures in the Arctic, which is warming about twice as fast as other parts of the planet, soared again during parts of 2017, and the region continued to lose sea ice and permafrost.</p><p class="card-text mt-4">Much of the eastern half of the United States had an abnormally warm February, an occurrence that scientists said was made more likely by climate change. Scientists found the fingerprints of warming in many other weather events as well, including a June heat wave that led to wildfires in southern Europe and extreme heat in Australia’s summer.</p>');
        $postEarth->setCategory($em->merge($this->getReference('category-earth')));

        $em->persist($postEarth);
        $em->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}