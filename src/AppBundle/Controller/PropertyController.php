<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Property;
use AppBundle\Entity\PropertyProduct;
use AppBundle\Entity\User;
use AppBundle\Form\Type\PropertyType;
use AppBundle\Service\Mailer\MailSender;
use AppBundle\Service\Mailer\MailSenderManager;
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
       $properties = $this->get("app.property_manager")->findBy($user);

        return $this->render(":property:list.html.twig",[
            "property" => $properties
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
        $form = $this->createForm(PropertyType::class);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->render(":property:create.html.twig",[
                "form" => $form->createView()
            ]);
        }

        /** @var Property $data */
        $data = $form->getData();

        $date = $data->getStart();

        $date->modify("+".$data->getType()->getLimitDays()."day");
        $data->setEnd($date);

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
                $product_create = $this->addImage($product_create);
            }

            $this->get('app.property_product_manager')->persist($product_create);
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
        if($user !== $property->getOwner()){
            return $this->render("error/error.html.twig",[
                "status_text" => "Access denied ",
                "status_code" => 403
            ]);
        }

        $form = $this->createForm(PropertyType::class,$property);
        $form->handleRequest($request);
        $product = $this->get("app.property_product_manager")->findByProperty($property);

        if (!$form->isValid()) {
            return $this->render(":property:update.html.twig",[
                "form" => $form->createView(),
                "property" => $property,
                "product" => $product
            ]);
        }

        /** @var Property $data */
        $data = $form->getData();
        if($data->getFilePdf()){
            $this->addAvatar($data);
        }
        $data->setOwner($user);
        $products = $request->request->all()['product'];
        $files = $request->files->all()['product'];

        foreach ($product as $product_create){
            $id = $product_create->getId();
            $product_create->setName($products["product".$id.""]["name"]);

            $product_create->setCount($products["product".$id.""]["qty"]);

            $product_create->setType($products["product".$id.""]["sizes"]);

            if($files['product'.$id.'']["image"]){
                $product_create->setImageFile($files['product'.$id.'']["image"]);
                $product_create = $this->addImage($product_create);
            }

            $this->get('app.property_product_manager')->persist($product_create);
        }
        $this->get('app.property_manager')->persist($data);

        return $this->render(":property:update.html.twig",[
            "form" => $form->createView(),
            "property" => $property,
            "product" => $product
        ]);
    }

    /**
     * @Route("/share/", name="my_share")
     */
    public function shareAction(){

        $user = $this->getUser();
        $properties = $this->get("app.price_product.manager")->findBy($user);

        return $this->render(":property:mylist.html.twig",[
            "properties" => $properties
        ]);
    }

    /**
     * @Route("/my/property/{id}", name="my_property")
     *
     * @param Property $property
     * @return mixed
     */
    public function myPropertyAction(Property $property)
    {
        $user = $this->getUser();

        if($user !== $property->getOwner()){
            return $this->render("error/error.html.twig",[
                "status_text" => "Access denied ",
                "status_code" => 403
            ]);
        }

        $product = $this->get("app.property_product_manager")->findByProperty($property);

        return $this->render(":property:share_active.html.twig",[
            "property" => $property,
            "product" => $product
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
