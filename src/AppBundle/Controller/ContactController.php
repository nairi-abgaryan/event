<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
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
     * @Route("/footer", name="list_contact")
     * @Method({"GET"})
     *
     * @return View|Response
     */
    public function footerAction()
    {
        $contact = $this->get("app.contact_manager")->findAll();

        return $this->render(':default:footer.html.twig',[
            "contact" => $contact
        ]);
    }


    /**
     * List user States
     *
     * @Route("/", name="list_contact")
     * @Method({"GET"})
     *
     * @return View|Response
     */
    public function contactAction()
    {
        $contact = $this->get("app.contact_manager")->findAll();

        return $this->render(':show:contact.html.twig',[
            "contact" => $contact
        ]);
    }
}

