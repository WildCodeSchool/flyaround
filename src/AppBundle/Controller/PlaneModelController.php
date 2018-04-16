<?php

/**
 * PlaneModel controller file
 *
 * PHP Version 7.1
 *
 * @category Controller
 * @package  Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

namespace AppBundle\Controller;

use AppBundle\Entity\PlaneModel;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Don't forget to use Http component for Response and Request types
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

// Don't forget to use Method and Route classes for annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Planemodel controller.
 *
 * @Route("planemodel")
 *
 * @category Controller
 * @package  Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
class PlaneModelController extends Controller
{
    /**
     * Lists all planeModel entities.
     *
     * @Route("/",    name="planemodel_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $planeModels = $em->getRepository('AppBundle:PlaneModel')->findAll();

        return $this->render(
            'planemodel/index.html.twig', array(
                'planeModels' => $planeModels,
            )
        );
    }

    /**
     * Creates a new planeModel entity.
     *
     * @param Request $request New posted info
     *
     * @Route("/new",  name="planemodel_new")
     * @Method({"GET", "POST"})
     * @return         Response A Response instance
     */
    public function newAction(Request $request)
    {
        $planeModel = new Planemodel();
        $form = $this->createForm('AppBundle\Form\PlaneModelType', $planeModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($planeModel);
            $em->flush();

            return $this->redirectToRoute('planemodel_show', array('id' => $planeModel->getId()));
        }

        return $this->render(
            'planemodel/new.html.twig', array(
                'planeModel' => $planeModel,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a planeModel entity.
     *
     * @param PlaneModel $planeModel The planeModel entity
     *
     * @Route  ("/{id}", name="planemodel_show")
     * @Method ("GET")
     * @return Response A Response instance
     */
    public function showAction(PlaneModel $planeModel)
    {
        $deleteForm = $this->_createDeleteForm($planeModel);

        return $this->render(
            'planemodel/show.html.twig', array(
                'planeModel' => $planeModel,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing planeModel entity.
     *
     * @param Request    $request    Edited post data
     * @param PlaneModel $planeModel The planeModel entity
     *
     * @Route  ("/{id}/edit", name="planemodel_edit")
     * @Method ({"GET", "POST"})
     * @return Response A Response instance
     */
    public function editAction(Request $request, PlaneModel $planeModel)
    {
        $deleteForm = $this->_createDeleteForm($planeModel);
        $editForm = $this->createForm('AppBundle\Form\PlaneModelType', $planeModel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('planemodel_edit', array('id' => $planeModel->getId()));
        }

        return $this->render(
            'planemodel/edit.html.twig', array(
                'planeModel' => $planeModel,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a planeModel entity.
     *
     * @param Request    $request    Deleted posted data
     * @param PlaneModel $planeModel The planeModel entity
     *
     * @Route  ("/{id}", name="planemodel_delete")
     * @Method ("DELETE")
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, PlaneModel $planeModel)
    {
        $form = $this->_createDeleteForm($planeModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($planeModel);
            $em->flush();
        }

        return $this->redirectToRoute('planemodel_index');
    }

    /**
     * Creates a form to delete a planeModel entity.
     *
     * @param PlaneModel $planeModel The planeModel entity
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function _createDeleteForm(PlaneModel $planeModel)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('planemodel_delete', array('id' => $planeModel->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
