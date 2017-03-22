<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/price/")
 */
class NewsController extends FOSRestController
{
    /**
     * @Route("/", name="create_price")
     */
    public function createAction()
    {

    }
}