<?php

/**
 * Review controller file
 *
 * PHP Version 7.1
 *
 * @category Controller
 * @package  Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Review;
use AppBundle\Form\ReviewType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Don't forget to use Http component for Response and Request types
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\FormBuilderInterface;

// Don't forget to use Method and Route classes for annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Review controller.
 *
 * @Route("review")
 *
 * @category Controller
 * @package  Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
class ReviewController extends Controller
{
    /**
     * Lists all review entities.
     *
     * @Route  ("/", name="review_index")
     * @Method ("GET")
     * @return Response A Response instance
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reviews = $em->getRepository('AppBundle:Review')->findAll();

        return $this->render(
            'review/index.html.twig', array(
                'reviews' => $reviews,
            )
        );
    }

    /**
     * Creates a new review entity.
     *
     * @param Request $request New posted info
     *
     * @Route  ("/new", name="review_new")
     * @Method ({"GET", "POST"})
     * @return Response A Response instance
     */
    public function newAction(Request $request)
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($review);
            $em->flush();

            return $this->redirect($this->generateUrl('review_show', array('id' => $review->getId())));
        }

        return $this->render(
            'review/new.html.twig', array(
                'review' => $review,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a review entity.
     *
     * @param Review $review The review entity
     *
     * @Route  ("/{id}", name="review_show")
     * @Method ("GET")
     * @return Response A Response instance
     */
    public function showAction(Review $review)
    {
        $deleteForm = $this->_createDeleteForm($review);

        return $this->render(
            'review/show.html.twig', array(
                'review' => $review,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing review entity.
     *
     * @param Request $request Edited post info
     * @param Review  $review  The review entity
     *
     * @Route  ("/{id}/edit", name="review_edit")
     * @Method ({"GET", "POST"})
     * @return Response A Response instance
     */
    public function editAction(Request $request, Review $review)
    {
        $deleteForm = $this->_createDeleteForm($review);
        $editForm = $this->createForm('AppBundle\Form\ReviewType', $review);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('review_edit', array('id' => $review->getId()));
        }

        return $this->render(
            'review/edit.html.twig', array(
                'review' => $review,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a review entity.
     *
     * @param Request $request Deleted posted info
     * @param Review  $review  The review entity
     *
     * @Route  ("/{id}", name="review_delete")
     * @Method ("DELETE")
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Review $review)
    {
        $form = $this->_createDeleteForm($review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($review);
            $em->flush();
        }

        return $this->redirectToRoute('review_index');
    }

    /**
     * Creates a form to delete a review entity.
     *
     * @param Review $review The review entity
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function _createDeleteForm(Review $review)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('review_delete', array('id' => $review->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}