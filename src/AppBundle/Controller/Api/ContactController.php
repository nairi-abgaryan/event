<?php

namespace AppBundle\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/contact")
 */
class ContactController extends FOSRestController
{
    /**
     * List user States
     *
     * @Route("/", name="api.contact")
     * @Method({"GET"})
     *
     * @ApiDoc(
     *     section="Contact"
     * )
     *
     * @return View|Response
     */
    public function listAction()
    {
        return $this->render('@SonataAdmin/ajax_layout.html.twig');
    }
}

