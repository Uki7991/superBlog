<?php

namespace PostBundle\Controller;

use PaymentBundle\StripeCreator;
use PostBundle\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Book controller.
 */
class BookController extends Controller
{
    /**
     * Lists all book entities.
     *
     * @Route("/books", name="book_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $books = $em->getRepository('PostBundle:Book')->findBy([], ['price' => 'ASC']);

        $em = $this->getDoctrine()->getManager();
        $catRepo = $em->getRepository('PostBundle:Category');
        $tagRepo = $em->getRepository('PostBundle:Tag');

        $bigTag = $tagRepo->findBigTag();

        $csrfToken = $this->get('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;


        return $this->render('@Post/book/index.html.twig', array(
            'books' => $books,
            'categories' => $catRepo->getParentCatsR(),
            'tags' => $tagRepo->findAll(),
            'bigTag' => $bigTag['counts'],
            'csrf_token' => $csrfToken,
        ));
    }

    /**
     * Creates a new book entity.
     *
     * @Route("/book/new", name="book_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $book = new Book();
        $form = $this->createForm('PostBundle\Form\BookType', $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute('book_show', array('id' => $book->getId()));
        }

        return $this->render('@Post/book/new.html.twig', array(
            'book' => $book,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a book entity.
     *
     * @Route("/book/{id}", name="book_show")
     * @Method("GET")
     */
    public function showAction(Book $book)
    {
        $em = $this->getDoctrine()->getManager();
        $catRepo = $em->getRepository('PostBundle:Category');
        $tagRepo = $em->getRepository('PostBundle:Tag');

        $bigTag = $tagRepo->findBigTag();

        $csrfToken = $this->get('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $deleteForm = $this->createDeleteForm($book);

        return $this->render('@Post/book/show.html.twig', array(
            'book' => $book,
            'delete_form' => $deleteForm->createView(),
            'categories' => $catRepo->getParentCatsR(),
            'tags' => $tagRepo->findAll(),
            'bigTag' => $bigTag['counts'],
            'csrf_token' => $csrfToken,
        ));
    }

    /**
     * Displays a form to edit an existing book entity.
     *
     * @Route("/book/{id}/edit", name="book_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Book $book)
    {
        $deleteForm = $this->createDeleteForm($book);
        $editForm = $this->createForm('PostBundle\Form\BookType', $book);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('book_edit', array('id' => $book->getId()));
        }

        return $this->render('@Post/book/edit.html.twig', array(
            'book' => $book,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a book entity.
     *
     * @Route("/book/{id}", name="book_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Book $book)
    {
        $form = $this->createDeleteForm($book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($book);
            $em->flush();
        }

        return $this->redirectToRoute('book_index');
    }

    /**
     * Creates a form to delete a book entity.
     *
     * @param Book $book The book entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Book $book)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('book_delete', array('id' => $book->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @Route("/book/buy/{id}", name="book_buy")
     * @Method("GET")
     *
     * @param Book $book
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function buyBook(Book $book)
    {
        $em = $this->getDoctrine()->getManager();
        $catRepo = $em->getRepository('PostBundle:Category');
        $tagRepo = $em->getRepository('PostBundle:Tag');

        $bigTag = $tagRepo->findBigTag();

        $csrfToken = $this->get('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $stripeCreator = new StripeCreator();

        $secret = $this->getParameter('payment.stripe.secretkey');
        $publish = $this->getParameter('payment.stripe.publishablekey');

        $stripe = $stripeCreator->factoryMethod()->init($secret, $publish);

        return $this->render('@Post/book/buy.html.twig', array(
            'book' => $book,
            'categories' => $catRepo->getParentCatsR(),
            'tags' => $tagRepo->findAll(),
            'bigTag' => $bigTag['counts'],
            'csrf_token' => $csrfToken,
            'stripe' => $stripe,
        ));
    }
}
