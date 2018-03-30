<?php

namespace PostBundle\Controller;

use PostBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class TagController
 *
 */
class TagController extends Controller
{
    /**
     * @Configuration\Route("/tag/{slug}", name="tag_show")
     * @Configuration\Method("GET")
     *
     * @param $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $tagRepo = $em->getRepository('PostBundle:Tag');
        $catRepo = $em->getRepository('PostBundle:Category');

        $categories = $catRepo->findAll();
        $tags = $tagRepo->findAll();
        $activeTag = $tagRepo->findOneBy(['slugName' => $slug]);
        $posts = $activeTag->getPosts();
        $bigTag = $tagRepo->findBigTag();

        return $this->render('@Post/tag/show.html.twig', [
            'tags' => $tags,
            'categories' => $categories,
            'active' => $activeTag,
            'posts' => $posts,
            'bigTag' => $bigTag['counts'],
        ]);
    }

    /**
     * @Configuration\Route("/api/tags")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function allTags()
    {
        $tags = $this->getDoctrine()->getManager()->getRepository('PostBundle:Tag')->findAllApi();

        return $this->json($tags);
    }
}
