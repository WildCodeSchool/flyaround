<?php

/**
 * Site controller file
 *
 * PHP Version 7.1
 *
 * @category Controller
 * @package  Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Site;

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
 * Site controller.
 *
 * @Route("site")
 *
 * @category Controller
 * @package  Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
class SiteController extends Controller
{
    /**
     * Lists all site entities.
     *
     * @Route("/",    name="site_index")
     * @Method("GET")
     * @return        Response A Response instance
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sites = $em->getRepository('AppBundle:Site')->findAll();

        return $this->render(
            'site/index.html.twig', array(
                'sites' => $sites,
            )
        );
    }

    /**
     * Finds and displays a site entity.
     *
     * @param Site $site The site entity
     *
     * @Route("/{id}", name="site_show")
     * @Method("GET")
     * @return         Response A Response instance
     */
    public function showAction(Site $site)
    {

        return $this->render(
            'site/show.html.twig', array(
                'site' => $site,
            )
        );
    }
}
