<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Privacy;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/privacy")
 */
class PrivacyController extends FOSRestController
{
    /**
     * @Route("/", name="privacy_list")
     */
    public function listAction()
    {
        $privacy = $this->get("app.privacy.manager")->findAll();
        return $this->render(":privacy:list.html.twig", [
            "privacy"=>$privacy
        ]);
    }

    /**
     * @Route("/{id}/", name="privacy")
     * @param Privacy $privacy
     * @return mixed
     */
    public function newsAction(Privacy $privacy)
    {
        $object = $this->get("app.privacy.manager")->findAll();
        return $this->render(":privacy:single.html.twig", [
            "privacy"=>$privacy,
            "object" => $object
        ]);
    }
}