<?php

namespace AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/states")
 */
class StateController extends Controller
{
    /**
     * List user States
     *
     * @Route("/", name="api.list_states")
     */
    public function listAction()
    {
        $state = $this->get("app.property.type_manager")->find();

        return $this->render('base.html.twig', array(
            'name' => $state
        ));
    }
}

