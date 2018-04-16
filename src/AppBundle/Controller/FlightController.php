<?php

/**
 * Flight controller file
 *
 * PHP Version 7.1
 *
 * @category Controller
 * @package  Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Flight;
use AppBundle\Service\FlightInfo;

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
 * Flight controller.
 *
 * @Route("flight")
 *
 * @category Controller
 * @package  Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
class FlightController extends Controller
{
    /**
     * Lists all flight entities.
     *
     * @Route("/",    name="flight_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $flights = $em->getRepository('AppBundle:Flight')->findAll();

        return $this->render(
            'flight/index.html.twig', array(
                'flights' => $flights,
            )
        );
    }

    /**
     * Creates a new flight entity.
     *
     * @param Request $request New posted info
     *
     * @Route  ("/new", name="flight_new")
     * @Method ({"GET", "POST"})
     * @return Response A Response instance
     */
    public function newAction(Request $request)
    {
        $flight = new Flight();
        $form = $this->createForm('AppBundle\Form\FlightType', $flight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($flight);
            $em->flush();

            return $this->redirectToRoute('flight_show', array('id' => $flight->getId()));
        }

        return $this->render(
            'flight/new.html.twig', array(
                'flight' => $flight,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a flight entity.
     *
     * @param Flight     $flight     The flight entity
     * @param FlightInfo $flightInfo FlightInfo typehint service
     *
     * @Route  ("/{id}", name="flight_show")
     * @Method ("GET")
     * @return Response A Response instance
     */
    public function showAction(Flight $flight, FlightInfo $flightInfo)
    {
        $deleteForm = $this->_createDeleteForm($flight);

        // Calculate a flight distance between departure and arrival
        $distance = $flightInfo->getDistance(
            $flight->getDeparture()->getLatitude(),
            $flight->getDeparture()->getLongitude(),
            $flight->getArrival()->getLatitude(),
            $flight->getArrival()->getLongitude()
        );

        // Calculate the flight time according to the flight distance
        $time = $flightInfo->getTime(
            $distance,
            $flight->getPlane()->getCruiseSpeed()
        );

        return $this->render(
            'flight/show.html.twig', array(
                'flight' => $flight,
                'distance' => $distance,
                'time' => $time,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing flight entity.
     *
     * @param Request $request Edited post info
     * @param Flight  $flight  The flight entity
     *
     * @Route  ("/{id}/edit", name="flight_edit")
     * @Method ({"GET", "POST"})
     * @return Response A Response instance
     */
    public function editAction(Request $request, Flight $flight)
    {
        $deleteForm = $this->_createDeleteForm($flight);
        $editForm = $this->createForm('AppBundle\Form\FlightType', $flight);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('flight_edit', array('id' => $flight->getId()));
        }

        return $this->render(
            'flight/edit.html.twig', array(
                'flight' => $flight,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a flight entity.
     *
     * @param Request $request Deleted posted info
     * @param Flight  $flight  The flight entity
     *
     * @Route  ("/{id}", name="flight_delete")
     * @Method ("DELETE")
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Flight $flight)
    {
        $form = $this->_createDeleteForm($flight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($flight);
            $em->flush();
        }

        return $this->redirectToRoute('flight_index');
    }

    /**
     * Creates a form to delete a flight entity.
     *
     * @param Flight $flight The flight entity
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function _createDeleteForm(Flight $flight)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('flight_delete', array('id' => $flight->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
