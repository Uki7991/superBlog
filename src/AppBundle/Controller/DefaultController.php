<?php

namespace AppBundle\Controller;

use Couchbase\Document;
use PostBundle\Entity\Category;
use PostBundle\Entity\Post;
use PostBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\NotBlank;

class DefaultController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("/", name="homepage")
     *
     * @return Response
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
     *
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

        if ('tags' === $type) {
            $data = $em->getRepository(Tag::class)->findApiTags($query);
        }
        if ('posts' === $type) {
            $data = $em->getRepository(Post::class)->findApiPosts($query);
        }
        if ('categories' === $type) {
            $data = $em->getRepository(Category::class)->findApiCats($query);
        }

        return $this->json($data);
    }

    /**
     * @param Request $request
     *
     * @Route("/upload-image-tiny", name="upload-image-tiny")
     *
     * @Method("POST")
     *
     * @return Response
     */
    public function upload(Request $request)
    {
        /**
         * @var UploadedFile $temp
        */
        $temp = $request->files->get('file');

        $temp->move($this->getParameter('web_dir').$this->getParameter('posts_img_dir'), $temp->getClientOriginalName());

        $filePath = $this->getParameter('posts_img_dir').$temp->getClientOriginalName();

        return $this->json(array('location' => $filePath));
    }

    /**
     * @Route("/terms")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function terms()
    {
        return $this->render(':default:terms.html.twig');
    }
}
