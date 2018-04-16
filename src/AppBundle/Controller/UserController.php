<?php

/**
 * User controller file
 *
 * PHP Version 7.1
 *
 * @category Controller
 * @package  Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;

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
 * User controller.
 *
 * @Route("user")
 *
 * @category Controller
 * @package  Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/",    name="user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render(
            'user/index.html.twig', array(
                'users' => $users,
            )
        );
    }

    /**
     * Creates a new user entity.
     *
     * @param Request $request New posted info
     *
     * @Route("/new",  name="user_new")
     * @Method({"GET", "POST"})
     * @return         Response A Response instance
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }

        return $this->render(
            'user/new.html.twig', array(
                'user' => $user,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a user entity.
     *
     * @param User $user The user entity
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     * @return         Response A Response instance
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->_createDeleteForm($user);

        return $this->render(
            'user/show.html.twig', array(
                'user' => $user,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @param Request $request Edited post info
     * @param User    $user    The user entity
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Method({"GET",      "POST"})
     * @return              Response A Response instance
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->_createDeleteForm($user);
        $editForm = $this->createForm('AppBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render(
            'user/edit.html.twig', array(
                'user' => $user,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a user entity.
     *
     * @param Request $request Deleted posted info
     * @param User    $user    The user entity
     *
     * @Route("/{id}",   name="user_delete")
     * @Method("DELETE")
     * @return           RedirectResponse
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->_createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function _createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
