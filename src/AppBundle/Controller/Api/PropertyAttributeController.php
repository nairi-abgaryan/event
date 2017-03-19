<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\PropertyAttribute;
use AppBundle\Form\Type\PropertyAttributeType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/properties/attributes")
 */
class PropertyAttributeController extends FOSRestController
{
    /**
     * Create property attribute.
     *
     * @Route("/", name="api.create_property_attribute")
     * @Method({"POST"})
     *
     * @ApiDoc(
     *     section="Properties",
     *     input={
     *          "class"="AppBundle\Form\Type\PropertyAttributeType",
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
        $form = $this->createForm(PropertyAttributeType::class);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return View::create($form, 400);
        }

        $propertyAttribute = $this->get('app.property_attribute_manager')->persist($form->getData());
        $this->addImage($propertyAttribute);
        $view = $this->view($propertyAttribute->getProperty(), 201);
        return $this->handleView($view);
    }

    /**
     * Update property attribute.
     *
     * @Route("/{id}/", name="api.update_property_attribute")
     * @Method({"PUT"})
     *
     * @ApiDoc(
     *     section="Properties",
     *     input={
     *          "class"="AppBundle\Form\Type\PropertyAttributeType",
     *          "name"=""
     *     }
     * )
     *
     * @param Request           $request
     * @param PropertyAttribute $propertyAttribute
     *
     * @return View|Response
     */
    public function updateAction(Request $request, PropertyAttribute $propertyAttribute)
    {
        $form = $this->createForm(PropertyAttributeType::class, $propertyAttribute);
        $form->submit($request->request->all(), false);

        if (!$form->isValid()) {
            return View::create($form, 400);
        }

        $propertyAttribute = $this->get('app.property_attribute_manager')->persist($form->getData());
        $this->addImage($propertyAttribute);
        $view = $this->view($propertyAttribute->getProperty(), 200);

        return $this->handleView($view);
    }

    /**
     * @param PropertyAttribute $propertyAttribute
     */
    private function addImage(PropertyAttribute $propertyAttribute)
    {
        $image = $this->get('app.image_manager')->upload(
            $propertyAttribute->getImageFile(),
            $this->getUser(),
            $propertyAttribute->getImage()
        );
        $propertyAttribute->setImage($image);
        $this->get('app.property_attribute_manager')->persist($propertyAttribute);
    }
}
