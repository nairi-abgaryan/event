<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/properties/attributes/types")
 */
class ProductTypeController extends FOSRestController
{
    /**
     * List availabe property attribute types.
     *
     * @Route("/", name="api.list_property_attribute_types")
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
     * @param Request $request
     *
     * @return View|Response
     */
    public function listAction(Request $request)
    {
        $items = $this->get('app.property_attribute_type_manager')->findAll();
        $paginatedItems = $this->get('app.pagination_factory')
            ->createCollection($items, $request, 'api.list_property_attribute_types');

        $view = $this->view($paginatedItems, 200);

        return $this->handleView($view);
    }
}
