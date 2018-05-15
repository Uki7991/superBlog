<?php

namespace PostBundle\Controller;

use PostBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
    public function show(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $tagRepo = $em->getRepository('PostBundle:Tag');
        $catRepo = $em->getRepository('PostBundle:Category');

        $categories = $catRepo->findAll();
        $tags = $tagRepo->findAll();
        $activeTag = $tagRepo->findOneBy(['slugName' => $slug]);
        $posts = $activeTag->getPosts();
        $bigTag = $tagRepo->findBigTag();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('@Post/tag/show.html.twig', [
            'tags' => $tags,
            'categories' => $catRepo->getParentCatsR(),
            'active' => $activeTag,
            'posts' => $posts,
            'bigTag' => $bigTag['counts'],
            'pagination' => $pagination,
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
