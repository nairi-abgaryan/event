<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Property;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/tender")
 */
class TenderController extends FOSRestController
{
    /**
     *
     * @Route("/list/", name="list_property")
     * @Method({"GET"})
     *
     */
    public function listAction()
    {
        $type = $this->get("app.property.type_manager")->findAll();
        $i = 1;

        foreach ($type as $item) {
            $property[$i] = $this->get("app.property_manager")->findByTypeResultTwo($item);
            $i++;
        }

        return $this->render("tenders/list.html.twig",[
            "property" => $property
        ]);
    }

    /**
     * @Route("/sortlist/", name="list_type")
     * @Method({"GET"})
     *
     * @return mixed
     */
    public function listTypeAction(Request $request)
    {
        $type = $this->get("app.property.type_manager")->find($request->get("type"));

        $property["0"] = $this->get("app.property_manager")->findByType($type);

        $paginatedItems = $this->get('app.pagination_factory')
            ->createCollection($property["0"], $request, 'list_type');

        return $this->render("tenders/sort.html.twig",[
            "property" => $paginatedItems
        ]);
    }


    /**
     *
     * @Route("/list/property/{id}", name="get_property")
     * @Method({"GET"})
     * @Security("is_granted('ROLE_USER')")
     * @param Property $property
     * @return mixed
     */
    public function getAction(Property $property)
    {
        $property = $this->get("app.property_manager")->find($property);

        return $this->render(":tenders:single.html.twig",[
            "property" => $property
        ]);
    }
}