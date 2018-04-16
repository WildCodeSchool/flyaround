<?php

/**
 * Reservation controller file
 *
 * PHP Version 7.1
 *
 * @category Controller
 * @package  Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Reservation;
use AppBundle\Service\Mailer;

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
 * Reservation controller.
 *
 * @Route("reservation")
 *
 * @category Controller
 * @package  Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
class ReservationController extends Controller
{
    /**
     * Lists all reservation entities.
     *
     * @Route  ("/",    name="reservation_index")
     * @Method ("GET")
     * @return Response A Response instance
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reservations = $em->getRepository('AppBundle:Reservation')->findAll();

        return $this->render(
            'reservation/index.html.twig', array(
                'reservations' => $reservations,
            )
        );
    }

    /**
     * Creates a new reservation entity.
     *
     * @param Request $request New posted info
     * @param Mailer  $mailer  Mailer service
     *
     * @Route  ("/new", name="reservation_new")
     * @Method ({"GET", "POST"})
     * @return Response A Response instance
     */
    public function newAction(Request $request, Mailer $mailer)
    {
        $reservation = new Reservation();
        $form = $this->createForm('AppBundle\Form\ReservationType', $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();

            $mailer->sendEmail(
                'reservations@flyaround.com', $reservation->getFlight()->getPilot()->getEmail(),
                $reservation->getFlight()->getPilot()->getFirstName(), 'Réservation Flyaround',
                'Quelqu\'un vient de réserver une place sur votre vol. Merci de voyager avec Flyaround'
            );

            $mailer->sendEmail(
                'reservations@flyaround.com', $this->getUser()->getEmail(),
                $this->getUser()->getFirstName(), 'Réservation Flyaround',
                'Votre réservation est enregistrée. Merci de voyager avec Flyaround'
            );

            return $this->redirectToRoute('reservation_show', array('id' => $reservation->getId()));
        }

        return $this->render(
            'reservation/new.html.twig', array(
                'reservation' => $reservation,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a reservation entity.
     *
     * @param Reservation $reservation The reservation entity
     *
     * @Route  ("/{id}", name="reservation_show")
     * @Method ("GET")
     * @return Response A Response instance
     */
    public function showAction(Reservation $reservation)
    {
        $deleteForm = $this->_createDeleteForm($reservation);

        return $this->render(
            'reservation/show.html.twig', array(
                'reservation' => $reservation,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing reservation entity.
     *
     * @param Request     $request     Edited post info
     * @param Reservation $reservation The reservation entity
     *
     * @Route  ("/{id}/edit", name="reservation_edit")
     * @Method ({"GET", "POST"})
     * @return Response A Response instance
     */
    public function editAction(Request $request, Reservation $reservation)
    {
        $deleteForm = $this->_createDeleteForm($reservation);
        $editForm = $this->createForm('AppBundle\Form\ReservationType', $reservation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_edit', array('id' => $reservation->getId()));
        }

        return $this->render(
            'reservation/edit.html.twig', array(
                'reservation' => $reservation,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a reservation entity.
     *
     * @param Request     $request     Deleted posted info
     * @param Reservation $reservation The reservation entity
     *
     * @Route  ("/{id}", name="reservation_delete")
     * @Method ("DELETE")
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Reservation $reservation)
    {
        $form = $this->_createDeleteForm($reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reservation);
            $em->flush();
        }

        return $this->redirectToRoute('reservation_index');
    }

    /**
     * Creates a form to delete a reservation entity.
     *
     * @param Reservation $reservation The reservation entity
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function _createDeleteForm(Reservation $reservation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reservation_delete', array('id' => $reservation->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
