<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Property;
use AppBundle\Entity\PropertyProduct;
use AppBundle\Form\Type\PropertyType;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/properties")
 */
class PropertyController extends FOSRestController
{
    /**
     * Retrieve property.
     *
     * @Route("/my/{id}/", name="retrieve_property")
     * @Method({"GET"})
     *
     */
    public function retrieveAction()
    {
       return $this->getUser();
    }

    /**
     *
     * @Route("/mylist/", name="my_list_property")
     * @Method({"GET"})
     *
     */
    public function myListAction()
    {
        $user = $this->getUser();
        $property = $this->get("app.property_manager")->findBy($user);

        return $this->render(":property:list.html.twig",[
            "property" => $property
        ]);
    }


    /**
     * Create property
     *
     * @Route("/", name="create_property")
     *
     */
    public function createAction(Request $request)
    {
        $user = $this->getUser();

        $product = $request->request->all();

        $form = $this->createForm(PropertyType::class);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->render(":property:create.html.twig",[
                "form" => $form->createView()
            ]);
        }

        /** @var Property $data */
        $data = $form->getData();

        if($data->getFilePdf()){
            $this->addAvatar($data);
        }
        $data = $form->getData();
        $data->setOwner($user);

        $property = $this->get('app.property_manager')->persist($data);
        $products = $request->request->all()['product'];
        $files = $request->files->all()['product'];
        $i = 1;
        foreach ($products as $product){
            $product_create = $this->get("app.property_product_manager")->create();
            $product_create->setProperty($property);
            $product_create->setName($product["name"]);
            $product_create->setCount($product["qty"]);
            $product_create->setType($product["sizes"]);
            if($files['product'.$i.'']["image"]){
                $product_create->setImageFile($files['product'.$i.'']["image"]);
                $product = $this->addImage($product_create);
            }
            $this->get('app.property_product_manager')->persist($product);
            $i++;
        }

        $property = $this->get("app.property_manager")->findBy($user);

        return $this->render(":property:list.html.twig",[
            "property" => $property
        ]);
    }

    /**
     * Update property
     *
     * @Route("/property/{id}/", name="update_property")
     * @Security("is_granted('ROLE_USER')")
     *
     * @param Property $property
     * @return mixed
     */
    public function updateAction(Request $request, Property $property)
    {
        $user = $this->getUser();

        $form = $this->createForm(PropertyType::class,$property);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->render(":property:update.html.twig",[
                "form" => $form->createView(),
                "property" => $property
            ]);
        }


        /** @var Property $data */
        $data = $form->getData();
        if($data->getFilePdf()){
            $this->addAvatar($data);
        }
        $data->setOwner($user);

        $this->get('app.property_manager')->persist($data);
        $property = $this->get("app.property_manager")->findBy($user);
        return $this->render(":property:list.html.twig",[
            "form" => $form,
            "property" => $property
        ]);
    }

    /**
     * @param Property $property
     */
    private function addAvatar(Property $property)
    {
        $image = $this->get('app.file_manager')->upload($property->getFilePdf(), $this->getUser(), $property->getFile());
        $property->setFile($image);
        $this->get('app.property_manager')->persist($property);
    }

    /**
     * @param PropertyProduct $product
     *
     * @return PropertyProduct
     */
    private function addImage(PropertyProduct $product)
    {
        $image = $this->get('app.image_manager')->upload($product->getImageFile(), $this->getUser(), $product->getImage());
        $product->setImage($image);
        return $product;
    }

}
