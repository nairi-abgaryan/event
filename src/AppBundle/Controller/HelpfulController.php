<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Privacy;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/help")
 */
class HelpfulController extends FOSRestController
{
    /**
     * @Route("/", name="help_list")
     */
    public function listAction()
    {
        $help = $this->get("app.help.manager")->findAll();
        return $this->render(":help:list.html.twig", [
            "help"=>$help
        ]);
    }

}