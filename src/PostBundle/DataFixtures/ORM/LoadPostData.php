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

        $postSport = new Post();
        $postSport->setTitle('2017 Was One of the Hottest Years on Record. And That Was Without El Niño.');
        $postSport->setBlockquote('<p class="card-text mt-4">The world in 2017 saw some of the highest average surface temperatures ever recorded, surprising scientists who had expected sharper retreat from recent record years.</p>');
        $postSport->setContent('<p class="card-text mt-4">The world in 2017 saw some of the highest average surface temperatures ever recorded, surprising scientists who had expected sharper retreat from recent record years.</p><p class="card-text mt-4">Scientists at NASA on Thursday ranked last year as the second-warmest year since reliable record-keeping began in 1880, trailing only 2016. The National Oceanic and Atmospheric Administration, which uses a different analytical method, ranked it third, behind 2016 and 2015.</p><p class="card-text mt-4">What made the numbers unexpected was that last year had no El Niño, a shift in tropical Pacific weather patterns that is usually linked to record-setting heat and that contributed to record highs the previous two years. In fact, last year should have benefited from a weak version of the opposite phenomenon, La Niña, which is generally associated with lower atmospheric temperatures.</p><p class="card-text mt-4">“This is the new normal,” said Gavin A. Schmidt, director of the Goddard Institute for Space Studies, the NASA group that conducted the analysis. But, he said, “It’s also changing. It’s not that we’ve gotten to a new plateau — this isn’t where we’ll stay. In ten years we’re going to say ‘oh look, another record decade of warming temperatures.’”</p><p class="card-text mt-4">An analysis by a private independent group, Berkeley Earth, ranked last year as the warmest year on record without El Niño. Zeke Hausfather, a researcher with the group, said that despite the weak La Niña, “It doesn’t seem like there’s any evidence things are cooling down.”</p><p class="card-text mt-4">By both the NASA and NOAA analyses, 17 of the 18 warmest years since modern record-keeping began have occurred since 2001. Overall, fueled by emissions of carbon dioxide and other greenhouse gases, temperatures have increased more than 1 degree Celsius (1.8 degrees Fahrenheit) since the late 19th century.</p><p class="card-text mt-4">In order to avoid the worst consequences of climate change, scientists say global temperatures must not increase more than 2 degrees Celsius.</p><p class="card-text mt-4">The warming trend comes at a time that President Donald Trump is dialing back many climate-related regulations and policies. Last year he announced that the United States would withdraw from the 2015 Paris climate accord and repeal the Clean Power Plan, an Obama-era measure designed to reduce emissions from power plants.</p><p class="card-text mt-4">But more than statements from politicians or data from scientists, events last year reminded the world that the climate is changing.</p><p class="card-text mt-4">Temperatures in the Arctic, which is warming about twice as fast as other parts of the planet, soared again during parts of 2017, and the region continued to lose sea ice and permafrost.</p><p class="card-text mt-4">Much of the eastern half of the United States had an abnormally warm February, an occurrence that scientists said was made more likely by climate change. Scientists found the fingerprints of warming in many other weather events as well, including a June heat wave that led to wildfires in southern Europe and extreme heat in Australia’s summer.</p>');
        $postSport->setCategory($em->merge($this->getReference('category-sport')));

        $postPro = new Post();
        $postPro->setTitle('2017 Was One of the Hottest Years on Record. And That Was Without El Niño.');
        $postPro->setBlockquote('<p class="card-text mt-4">The world in 2017 saw some of the highest average surface temperatures ever recorded, surprising scientists who had expected sharper retreat from recent record years.</p>');
        $postPro->setContent('<p class="card-text mt-4">The world in 2017 saw some of the highest average surface temperatures ever recorded, surprising scientists who had expected sharper retreat from recent record years.</p><p class="card-text mt-4">Scientists at NASA on Thursday ranked last year as the second-warmest year since reliable record-keeping began in 1880, trailing only 2016. The National Oceanic and Atmospheric Administration, which uses a different analytical method, ranked it third, behind 2016 and 2015.</p><p class="card-text mt-4">What made the numbers unexpected was that last year had no El Niño, a shift in tropical Pacific weather patterns that is usually linked to record-setting heat and that contributed to record highs the previous two years. In fact, last year should have benefited from a weak version of the opposite phenomenon, La Niña, which is generally associated with lower atmospheric temperatures.</p><p class="card-text mt-4">“This is the new normal,” said Gavin A. Schmidt, director of the Goddard Institute for Space Studies, the NASA group that conducted the analysis. But, he said, “It’s also changing. It’s not that we’ve gotten to a new plateau — this isn’t where we’ll stay. In ten years we’re going to say ‘oh look, another record decade of warming temperatures.’”</p><p class="card-text mt-4">An analysis by a private independent group, Berkeley Earth, ranked last year as the warmest year on record without El Niño. Zeke Hausfather, a researcher with the group, said that despite the weak La Niña, “It doesn’t seem like there’s any evidence things are cooling down.”</p><p class="card-text mt-4">By both the NASA and NOAA analyses, 17 of the 18 warmest years since modern record-keeping began have occurred since 2001. Overall, fueled by emissions of carbon dioxide and other greenhouse gases, temperatures have increased more than 1 degree Celsius (1.8 degrees Fahrenheit) since the late 19th century.</p><p class="card-text mt-4">In order to avoid the worst consequences of climate change, scientists say global temperatures must not increase more than 2 degrees Celsius.</p><p class="card-text mt-4">The warming trend comes at a time that President Donald Trump is dialing back many climate-related regulations and policies. Last year he announced that the United States would withdraw from the 2015 Paris climate accord and repeal the Clean Power Plan, an Obama-era measure designed to reduce emissions from power plants.</p><p class="card-text mt-4">But more than statements from politicians or data from scientists, events last year reminded the world that the climate is changing.</p><p class="card-text mt-4">Temperatures in the Arctic, which is warming about twice as fast as other parts of the planet, soared again during parts of 2017, and the region continued to lose sea ice and permafrost.</p><p class="card-text mt-4">Much of the eastern half of the United States had an abnormally warm February, an occurrence that scientists said was made more likely by climate change. Scientists found the fingerprints of warming in many other weather events as well, including a June heat wave that led to wildfires in southern Europe and extreme heat in Australia’s summer.</p>');
        $postPro->setCategory($em->merge($this->getReference('category-programming')));

        $postAnim = new Post();
        $postAnim->setTitle('2017 Was One of the Hottest Years on Record. And That Was Without El Niño.');
        $postAnim->setBlockquote('<p class="card-text mt-4">The world in 2017 saw some of the highest average surface temperatures ever recorded, surprising scientists who had expected sharper retreat from recent record years.</p>');
        $postAnim->setContent('<p class="card-text mt-4">The world in 2017 saw some of the highest average surface temperatures ever recorded, surprising scientists who had expected sharper retreat from recent record years.</p><p class="card-text mt-4">Scientists at NASA on Thursday ranked last year as the second-warmest year since reliable record-keeping began in 1880, trailing only 2016. The National Oceanic and Atmospheric Administration, which uses a different analytical method, ranked it third, behind 2016 and 2015.</p><p class="card-text mt-4">What made the numbers unexpected was that last year had no El Niño, a shift in tropical Pacific weather patterns that is usually linked to record-setting heat and that contributed to record highs the previous two years. In fact, last year should have benefited from a weak version of the opposite phenomenon, La Niña, which is generally associated with lower atmospheric temperatures.</p><p class="card-text mt-4">“This is the new normal,” said Gavin A. Schmidt, director of the Goddard Institute for Space Studies, the NASA group that conducted the analysis. But, he said, “It’s also changing. It’s not that we’ve gotten to a new plateau — this isn’t where we’ll stay. In ten years we’re going to say ‘oh look, another record decade of warming temperatures.’”</p><p class="card-text mt-4">An analysis by a private independent group, Berkeley Earth, ranked last year as the warmest year on record without El Niño. Zeke Hausfather, a researcher with the group, said that despite the weak La Niña, “It doesn’t seem like there’s any evidence things are cooling down.”</p><p class="card-text mt-4">By both the NASA and NOAA analyses, 17 of the 18 warmest years since modern record-keeping began have occurred since 2001. Overall, fueled by emissions of carbon dioxide and other greenhouse gases, temperatures have increased more than 1 degree Celsius (1.8 degrees Fahrenheit) since the late 19th century.</p><p class="card-text mt-4">In order to avoid the worst consequences of climate change, scientists say global temperatures must not increase more than 2 degrees Celsius.</p><p class="card-text mt-4">The warming trend comes at a time that President Donald Trump is dialing back many climate-related regulations and policies. Last year he announced that the United States would withdraw from the 2015 Paris climate accord and repeal the Clean Power Plan, an Obama-era measure designed to reduce emissions from power plants.</p><p class="card-text mt-4">But more than statements from politicians or data from scientists, events last year reminded the world that the climate is changing.</p><p class="card-text mt-4">Temperatures in the Arctic, which is warming about twice as fast as other parts of the planet, soared again during parts of 2017, and the region continued to lose sea ice and permafrost.</p><p class="card-text mt-4">Much of the eastern half of the United States had an abnormally warm February, an occurrence that scientists said was made more likely by climate change. Scientists found the fingerprints of warming in many other weather events as well, including a June heat wave that led to wildfires in southern Europe and extreme heat in Australia’s summer.</p>');
        $postAnim->setCategory($em->merge($this->getReference('category-animals')));

        $postPeople = new Post();
        $postPeople->setTitle('2017 Was One of the Hottest Years on Record. And That Was Without El Niño.');
        $postPeople->setBlockquote('<p class="card-text mt-4">The world in 2017 saw some of the highest average surface temperatures ever recorded, surprising scientists who had expected sharper retreat from recent record years.</p>');
        $postPeople->setContent('<p class="card-text mt-4">The world in 2017 saw some of the highest average surface temperatures ever recorded, surprising scientists who had expected sharper retreat from recent record years.</p><p class="card-text mt-4">Scientists at NASA on Thursday ranked last year as the second-warmest year since reliable record-keeping began in 1880, trailing only 2016. The National Oceanic and Atmospheric Administration, which uses a different analytical method, ranked it third, behind 2016 and 2015.</p><p class="card-text mt-4">What made the numbers unexpected was that last year had no El Niño, a shift in tropical Pacific weather patterns that is usually linked to record-setting heat and that contributed to record highs the previous two years. In fact, last year should have benefited from a weak version of the opposite phenomenon, La Niña, which is generally associated with lower atmospheric temperatures.</p><p class="card-text mt-4">“This is the new normal,” said Gavin A. Schmidt, director of the Goddard Institute for Space Studies, the NASA group that conducted the analysis. But, he said, “It’s also changing. It’s not that we’ve gotten to a new plateau — this isn’t where we’ll stay. In ten years we’re going to say ‘oh look, another record decade of warming temperatures.’”</p><p class="card-text mt-4">An analysis by a private independent group, Berkeley Earth, ranked last year as the warmest year on record without El Niño. Zeke Hausfather, a researcher with the group, said that despite the weak La Niña, “It doesn’t seem like there’s any evidence things are cooling down.”</p><p class="card-text mt-4">By both the NASA and NOAA analyses, 17 of the 18 warmest years since modern record-keeping began have occurred since 2001. Overall, fueled by emissions of carbon dioxide and other greenhouse gases, temperatures have increased more than 1 degree Celsius (1.8 degrees Fahrenheit) since the late 19th century.</p><p class="card-text mt-4">In order to avoid the worst consequences of climate change, scientists say global temperatures must not increase more than 2 degrees Celsius.</p><p class="card-text mt-4">The warming trend comes at a time that President Donald Trump is dialing back many climate-related regulations and policies. Last year he announced that the United States would withdraw from the 2015 Paris climate accord and repeal the Clean Power Plan, an Obama-era measure designed to reduce emissions from power plants.</p><p class="card-text mt-4">But more than statements from politicians or data from scientists, events last year reminded the world that the climate is changing.</p><p class="card-text mt-4">Temperatures in the Arctic, which is warming about twice as fast as other parts of the planet, soared again during parts of 2017, and the region continued to lose sea ice and permafrost.</p><p class="card-text mt-4">Much of the eastern half of the United States had an abnormally warm February, an occurrence that scientists said was made more likely by climate change. Scientists found the fingerprints of warming in many other weather events as well, including a June heat wave that led to wildfires in southern Europe and extreme heat in Australia’s summer.</p>');
        $postPeople->setCategory($em->merge($this->getReference('category-people')));

        $postComp = new Post();
        $postComp->setTitle('Building the VW of PC\'s');
        $postComp->setBlockquote('<p class="card-text mt-4">Before you can build the $300 network computer for the masses, you have to recruit the engineers to design it.</p>');
        $postComp->setContent('<p class="card-text mt-4">Before you can build the $300 network computer for the masses, you have to recruit the engineers to design it.</p><p class="card-text mt-4">That was another thing. They hated having to translate their work into dumbed-down metaphors for the shiny shoe set - the meddlesome lawyers, media scribblers, and potential corporate sponsors who came through wanting to "understand" without doing the hard work of paying attention. Oh, god. This was just one more reason that Francis Benoit was glad he was working here at the La Honda Research Center and not out there in some corporate start-up, because despite all the roll-up-your-shirtsleeves myths and stereotypes, when you got right down to it, working for a start-up meant he\'d spend 80 percent of his time doing complete bullshit - chasing VC money, writing technical documentation, hiring people - and all of it involved dumbing down your work. And the meetings! To participate in that game would be a waste of god-given talent, it would be a crime against his very own nature. Francis Benoit could just see himself cooped up in some office park, suffocating on his own unvented thoughts, poisoning himself, just to prove something to the shiny shoe set.</p><p class="card-text mt-4">Then there was the time that photographer and his camera crew came out from New York to shoot an ad for a new line of casual clothing, Lo-Tech Workware. Some Italian conglomerate had built up sufficient internal consensus to approve its ad agency\'s recommendation: put unassuming clothes on semifamous titans of the American computer industry, take pictures, and print the pictures alongside the slogan "High tech insiders wear Lo-Tech on the outside." The company hired the renowned Italian fashion photographer Adriano Paschetta, flew him out to San Francisco, and gave him first-class treatment for several days to primp his artistic temperament, then put him in an air-conditioned van for the trip down to Silicon Valley.</p><p class="card-text mt-4">The producer had received, by fax, very specific directions; they had found the turnoff for Old La Honda Road, passed over a little gangplank bridge, and ascended into an evergreen forest, where sword ferns straddled the one-lane road and neon velvet moss circled the tree trunks. But about 2 miles farther up the road, the asphalt became all cracked and broken so the wheels of their van started a drumbeat rump rump rump; then the canopy of forest overhanging the road began scraping the metal roof, and naturally they started thinking they\'d missed a turnoff, this couldn\'t be it, no way, something was wrong here, this couldn\'t be the way to the world-renowned La Honda Research Center.</p><p class="card-text mt-4">Right about when their ears popped from the altitude, they caught up with this fat guy on a frail 50-cc pedal-scooter, which was whining and bleeding a trail of oil-tainted blue smoke into the air. A plastic grocery bag dangled from the elbow of one arm; a diminutive Styrofoam helmet adorned his head.</p><p class="card-text mt-4">There was no room to pass, and the fat guy wasn\'t about to pull his scooter over and lose all his momentum, so they had no choice but to roll along behind him for the next mile and stare at the pale smile of flesh between his shorts and shirt.</p><p class="card-text mt-4">When the scooter-borne fat guy pulled into the entrance of the research center, Paschetta wondered if maybe all this was a prank set up by the boys in New York. Coming from Manhattan, where power is expressed, above all, in the concrete and glass of huge buildings rocketing skyward, well, they just expected more than a converted high school. Two three-story, I-shaped buildings with sloped, Spanish tile roofs bordered a field of overgrown, trampled grass. The buildings were brick but resurfaced with a thin layer of terra cotta or adobe, which had provided a porous surface for ivy to climb on. The flower beds, which separated the lawn from the buildings, had black-berry bushes growing in them. Blackberries! Where the camera crew came from, the blackberry bush was considered an invasive weed, even in the heat of summer with berries popping up beside every thorn; yet here it was growing in the flower beds, trimmed into orderly 4-foot-high thickets. The fat guy, who without locking it had leaned his scooter up against a bike rack in the parking lot, waddled along a pathway for several steps, the landing of each foot initiating a jiggle that tremored up and across the surface of his body. He reached into his grocery bag, dug around with his fist, and came out with a double-stick fruit popsicle. The thought then occurred to Adriano Paschetta that the whole notion implied by this campaign was dangerous - it might be a terrible and grave mistake to turn our couture over to a gang of brainiacs who cared not a wit about appearances.</p><p class="card-text mt-4">Hank Menzinger, the executive director of the center. The crew had never seen Hank Menzinger - didn\'t even know what he looked like; and as far as they could tell, nobody involved with the advertising campaign had seen whether or not he looked good in the clothes. Nobody had even checked his size, for god\'s sake - the clothes might not fit! All they knew about Hank Menzinger was that he could be found in Room 211, which was supposed to be upstairs in back, down a long hall.</p><p class="card-text mt-4">So they hauled their gear up the stairs and down the hall and knocked on Room 211, and a man inside said "Yup," and so they went in, banging their equipment on the door frame. There was something wrong with the room; this was certainly not the office of any titan they\'d ever seen. Where was the false fireplace, the leather-bound books, the regal oil painting of the officeholder? Where, above all else, was the secretary? Instead, there were two sleek leather couches opposite each other and on one of the couches sat a man. His head was tipped back to the ceiling. He had a shaved but stubbled head atop a lanky frame and looked pallid, like he might have just been let out of the hospital after a long sickness. He was wearing a green T-shirt with a line of tiny white lettering across the chest, too small to read at a distance. His eyes were also green, and Adriano Paschetta mustered all of his artistic sensibilities to find inspiration in the very greenness of those eyes. Of course, they assumed this man was Hank Menzinger and had no idea he was really Francis Benoit.</p><p class="card-text mt-4">Francis Benoit had been waiting 10 minutes for Hank Menzinger to finish his conference call in the inner room; waiting was not one of Francis\' strengths, and he wasn\'t going to let this crew of photographers or whatever they were keep him from giving Hank a piece of his mind. He took this crew in with his eyes and started stalling while his brain figured.</p><p class="card-text mt-4">"You\'re looking for Hank, huh? ... Who are you guys, some photo crew, rack of clothes, huh ... wait - this for an ad?"</p>');
        $postComp->setCategory($em->merge($this->getReference('category-computers')));

        $em->persist($postEarth);
        $em->persist($postPeople);
        $em->persist($postSport);
        $em->persist($postAnim);
        $em->persist($postComp);
        $em->persist($postPro);
        $em->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}