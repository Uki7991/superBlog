<?php

namespace AppBundle\Controller;

use PostBundle\Entity\Category;
use PostBundle\Entity\Post;
use PostBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\NotBlank;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/search", name="search")
     * @Method("GET")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->query->get('query');
        $type = $request->query->get('type');
        $em = $this->getDoctrine()->getManager();
        $data = [];

        if ($type === 'tags') {
            $data = $em->getRepository(Tag::class)->findApiTags($query);
        }
        if ($type === 'posts') {
            $data = $em->getRepository(Post::class)->findApiPosts($query);
        }
        if ($type === 'categories') {
            $data = $em->getRepository(Category::class)->findApiCats($query);
        }

        return $this->json($data);
    }

    /**
     * @Route("/upload-image-tiny", name="upload-image-tiny")
     * @Method("POST")
     */
    public function upload() {

        $imageFolder = "/uploads/images/";
        $web = '../web';
        reset ($_FILES);
        $temp = current($_FILES);
        $filetowrite = $web . $imageFolder . $temp['name'];
        move_uploaded_file($temp['tmp_name'], $filetowrite);
        $filetowrite = $imageFolder . $temp['name'];
        return $this->json(array('location' => $filetowrite));
    }
}
