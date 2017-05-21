<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Property;
use AppBundle\Form\Type\SearchType;
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
        $form = $this->createForm(SearchType::class);

        $type = $this->get("app.property.type_manager")->findAll();
        $i = 0;
        $property = [];

        foreach ($type as $item) {
            $property[$i] = $this->get("app.property_manager")->findByTypeResultTwo($item);
            $i++;
        }

        return $this->render("tenders/list.html.twig",[
            "property" => $property,
            "form" => $form->createView()
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

        $property = $this->get("app.property_manager")->findByType($type);

        $paginatedItems = $this->get('app.pagination_factory')
            ->createCollection($property, $request, 'list_type');

        $form = $this->createForm(SearchType::class);
        return $this->render("tenders/sortList.html.twig",[
            "property" => $paginatedItems,
            "form" => $form->createView()
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

    /**
     * @Route("/search", name="search_property")
     * @return mixed
     */
    public function searchAction(Request $request)
    {
        $data = $request->request->all()["search"];
        $type = $this->get("app.property.type_manager")->findAll();
        $propertyType = ['Ապրանք', 'Աշխատանք', 'Ծառաություն'];
        $start = new \DateTime("2017-01-01 00:00:00");
        $end = new \DateTime("2050-01-01 00:00:00");
        $category = $this->get("app.property_category_maneger")->findAll()->getQuery()->getResult();

        if($data['type'] != ''){
            $type = $this->get("app.property.type_manager")->find($data['type']);
        }

        if ($data["propertyType"] != '')
        {
            $propertyType = $data["propertyType"];
        }
        if ($data["start"] != '')
        {
            $start = new \DateTime($data["start"]);
        }
        if ($data["end"] != '')
        {
            $end = new \DateTime($data["end"]);
        }
        if(isset($data["category"]))
        {
            $category = $this->get("app.property_category_maneger")->findBy($data["category"]);
        };

        $property = $this->get("app.property_manager")->findByFilters($type, $propertyType, $start, $end, $category);

        $form = $this->createForm(SearchType::class);
        return $this->render(":tenders:sort.html.twig",
                [
                    "property"=>$property,
                    "form" => $form->createView()
                ]
        );
    }
}
