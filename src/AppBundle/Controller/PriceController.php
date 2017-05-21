<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Price;
use AppBundle\Entity\Property;
use AppBundle\Entity\PropertyProduct;
use AppBundle\Form\Type\PriceType;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/price")
 */
class PriceController extends FOSRestController
{
    /**
     * @Route("/{id}/", name="create_price")
     * @param Property $property
     * @return mixed
     */
    public function createAction(Request $request, Property $property)
    {
        $user = $this->getUser();
        $form = $this->createForm(PriceType::class, $request->request->all());
        $form->handleRequest($request);
        $products = $this->get("app.property_product_manager")->findByProperty($property);

        if (!$form->isValid()) {
            return $this->render(":price:create.html.twig",[
                "form" => $form->createView(),
                "products" => $products
            ]);
        }

        /** @var Price $data */
        $data = $form->getData();
        $files =  $request->files->all()["product"];

        foreach ($products as $key => $value){
            $id = $value->getId();

            if(isset($data["product"][$id]["price"]) && $data["product"][$id]["price"] != 0){

                $create = $this->get("app.price.manager")->create();
                $create->setDescription($data["description"]);
                $create->setProperty($property);
                $create->setProduct($value);
                $create->setOwner($user);
                $create->setPrice((int)$data["product"][$id]["price"]);

                $create->setFinancing($data["financing"]);
                $create->setShipment($data["shipment"]);

                if($files[$id]["file"]){
                    $create->setFilePdf($files[$id]["file"]);
                    $create = $this->addAvatar($create);
                }
                $this->get("app.price.manager")->persist($create);
            }

        }

        $count = $this->get("app.price.manager")->findByCount($property);
        $property->setPriceCount((int)$count["1"]);
        $this->get("app.property_manager")->persist($property);
        $create_activate = $this->get("app.price_product.manager")->create();

        $create_activate->setProperty($property);
        $create_activate->setOwner($user);
        $create_activate->setEstablished(0);
        $this->get("app.price_product.manager")->persist($create_activate);

        $message = "<html><body><h3>Ձեզ գնային առաջարկ է արել-><h3></body></html>".$user->getCompanyName()."
        Մրցույթի վերջանալու օրն է". date_format($property->getEnd(),"y-m-d");
        $this->get("app.mailer_service")->sendMail($message, $property->getOwner()->getEmail());

        $properties = $this->get("app.price_product.manager")->findBy($user);
        return new RedirectResponse($this->generateUrl("my_share",[
            "properties" => $properties
        ]));
    }

    /**
     * @Route("/product/price_list/{id}/", name="my_product_price")
     *
     * @param PropertyProduct $product
     * @return mixed
     */
    public function myPropertyPriceAction(PropertyProduct $product)
    {
        $user = $this->getUser();

        if($user !==  $product->getProperty()->getOwner()){
            return $this->render("error/error.html.twig",[
                "status_text" => "Access denied ",
                "status_code" => 403
            ]);
        }

        $pricelist = $this->get("app.price.manager")->findByProduct($product);
        return $this->render(":price:my_pricelist.html.twig",[
            "pricelist" => $pricelist
        ]);
    }

    /**
     * @Route("/product/done/{id}/", name="my_done_price")
     *
     * @param Price $price
     * @return mixed
     */
    public function doneProductPrice(Price $price)
    {
        $user = $this->getUser();

        if($user !==  $price->getProperty()->getOwner()){
            return $this->render("error/error.html.twig",[
                "status_text" => "Access denied ",
                "status_code" => 403
            ]);
        }

        $product = $price->getProduct();
        $product->setPriceOwner($price->getOwner());
        $this->get("app.property_product_manager")->persist($product);
        return $this->redirect($this->generateUrl("my_property",[
            "id" => $price->getProperty()->getId()
        ]));

    }

    /**
     * @param Price $price
     * @return Price $price
     */
    private function addAvatar(Price $price)
    {
        $image = $this->get('app.file_manager')->upload($price->getFilePdf(), $this->getUser(), $price->getFile());
        $price->setFile($image);
        return $price;
    }
}