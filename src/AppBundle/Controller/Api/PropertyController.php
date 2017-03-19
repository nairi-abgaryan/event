<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Property;
use AppBundle\Form\Type\PropertyType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/properties")
 */
class PropertyController extends FOSRestController
{
    /**
     * Retrieve property.
     *
     * @Route("/{id}/", name="api.retrieve_property")
     * @Method({"GET"})
     * @ApiDoc(section="Properties")
     *
     * @param Property $property
     *
     * @return View|Response
     */
    public function retrieveAction(Property $property)
    {
        $view = $this->view($property, 200);

        return $this->handleView($view);
    }

    /**
     * Create property
     *
     * @Route("/", name="api.create_property")
     * @Method({"POST"})
     *
     * @ApiDoc(
     *     section="Properties",
     *     input={
     *          "class"="AppBundle\Form\Type\PropertyType",
     *          "name"=""
     *     }
     * )
     *
     * @param Request $request
     *
     * @return View|Response
     */
    public function createAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(PropertyType::class);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return View::create($form, 400);
        }

        $data = $form->getData();
        $data->setOwner($user);

        $property = $this->get('app.property_maneger')->persist($data);
        $view = $this->view($property, 201);

        return $this->handleView($view);
    }
}
