<?php

namespace AppBundle\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/properties/category")
 */
class PropertyCategoryController extends FOSRestController
{
    /**
     * Create user.
     *
     * @Route("/", name="api.list_category")
     * @Method({"GET"})
     *
     * @ApiDoc(
     *     section="Properties",
     *     parameters={
     *          {"name"="page", "dataType"="integer", "required"=false, "description"="Page number"},
     *          {"name"="per_page", "dataType"="integer", "required"=false, "description"="Max page count"}
     *     }
     * )
     *
     * @return View|Response
     */
    public function listAction()
    {
        $items = $this->get('app.property_category')->findAll();


        return $this->handleView($items);
    }
}
