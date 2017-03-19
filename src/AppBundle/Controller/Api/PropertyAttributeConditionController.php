<?php

namespace AppBundle\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/properties/attributes/conditions")
 */
class PropertyAttributeConditionController extends FOSRestController
{
    /**
     * List available property attribute conditions.
     *
     * @Route("/", name="api.list_property_attribute_conditions")
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
        $items = $this->get('app.property_attribute_condition_manager')->findAll();
        $paginatedItems = $this->get('app.pagination_factory')
            ->createCollection($items, $request, 'api.list_property_attribute_conditions');

        $view = $this->view($paginatedItems, 200);

        return $this->handleView($view);
    }
}
