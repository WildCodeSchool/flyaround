<?php

/**
 * Listing controller file
 *
 * PHP Version 7.1
 *
 * @category Controller
 * @package  Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Flight;
use AppBundle\Entity\PlaneModel;
use AppBundle\Entity\Reservation;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Don't forget to use Http component for Response and Request types
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Don't forget to use Method and Route classes for annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Listing controller.
 *
 * @Route("listing")
 *
 * @category Controller
 * @package  Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
class ListingController extends Controller
{
    /**
     * List one reservation with one flight and one planemodel, with few IDs.
     *
     * @Route("/{reservation_id}/flight/{flight_id}/planemodel/{planemodel_id}", name="listing_index", requirements={"reservation_id": "\d+"})
     * @Method("GET")
     * @ParamConverter("reservation",                                            options={"mapping": {"reservation_id": "id"}})
     * @ParamConverter("flight",                                                 options={"mapping": {"flight_id": "id"}})
     * @ParamConverter("planemodel",                                             options={"mapping": {"planemodel_id": "id"}})
     * @return Response A Response instance
     */

    public function indexAction(Reservation $reservation, Flight $flight, PlaneModel $planemodel)
    {
        return $this->render(
            'listing/index.html.twig', array(
                'reservation' => $reservation,
                'flight' => $flight,
                'planemodel' => $planemodel
            )
        );
    }
}
