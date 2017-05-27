<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PriceProduct;
use AppBundle\Entity\Property;
use AppBundle\Form\Type\PropertyProductType;
use AppBundle\Form\Type\PropertyType;
use AppBundle\Service\Mailer\MailSender;
use AppBundle\Service\Mailer\MailSenderManager;
use Application\Sonata\MediaBundle\Entity\Media;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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

        $date = new \DateTime("now");
        $minutes_to_add = 5;
        $now = new \DateTime("now");
        $date->add(new \DateInterval('PT' . $minutes_to_add . 'M'));

        $date->format('Y-m-d H:i:s');

        $properties = $this->get("app.property_manager")->findByDate($now, $date);

        foreach ($properties as $value){
            $price = $this->get("app.price.manager")->findOneBy(["property" => $value]);
            $value->setCategoryType(3);
            $message  =  $this->render(":mail:end.tender.not.price.html.twig", [
                    "value" => $value
                ]);

            if($price){

                $value->setCategoryType(1);
                $message = $this->render(":mail:end.tender.html.twig", [
                    "value" => $value
                ]);
            }

            $this->get("app.mailer_service")->sendMail($message, $value->getOwner()->getEmail());
            $this->get("app.property_manager")->persist($value);
        }

        var_dump($properties);die();
    }

    /**
     *
     * @Route("/mylist/", name="my_list_property")
     * @Method({"GET"})
     * @Security("is_granted('ROLE_USER')")
     */
    public function myListAction()
    {
        $user = $this->getUser();
        $properties = $this->get("app.property_manager")->findBy($user);
        $date = new \DateTime("now");
        if(isset($_GET['category'])){
            switch ($_GET['category']){
                case 0:
                    break;
                case 1:
                    $cridantial = "property.categoryType = :category";
                    $param = 1;
                    $name = 'category';
                    $properties = $this->get("app.property_manager")->findByCategory($cridantial, $user, $name, $param);
                    break;
                case 2:
                    $cridantial = "property.end >= :date";
                    $param = $date;
                    $name = 'date';
                    $properties = $this->get("app.property_manager")->findByCategory($cridantial, $user, $name, $param);
                    break;
                case 3:
                    $cridantial = "property.categoryType = :category";
                    $param = 3;
                    $name = 'category';
                    $properties = $this->get("app.property_manager")->findByCategory($cridantial, $user, $name, $param);
                    break;
                case 4:
                    $cridantial = "property.removed = :removed";
                    $param = 1;
                    $name = 'removed';
                    $properties = $this->get("app.property_manager")->findByCategory($cridantial, $user, $name, $param);
                    break;
            }
        }


        return $this->render(":property:list.html.twig",[
            "property" => $properties
        ]);
    }


    /**
     * Create property
     *
     * @Route("/", name="create_property")
     * @Security("is_granted('ROLE_USER')")
     */
    public function createAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(PropertyType::class);
        $form_product = $this->createForm(PropertyProductType::class);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->render(":property:create.html.twig",[
                "form" => $form->createView(),
                "form_product" => $form_product->createView()
            ]);
        }

        /** @var Property $data */
        $data = $form->getData();

        $limit = $data->getType()->getLimitDays();
        $diff = $data->getEnd()->diff($data->getStart());

        if ($diff->days > $limit || $data->getEnd() < $data->getStart()){
            $startDate = new \DateTime($data->getStart()->format("Y-m-d H:i:s"));
            $data->setEnd($startDate->add(new \DateInterval('P'.$limit.'D')));
        }
        $time = date("H");
        $time1 = date("i");
        $data->getEnd()->setTime($time, $time1);
        $data->getStart()->setTime($time, $time1);

        if($data->getFilePdf()){
            $this->addAvatar($data);
        }

        $data = $form->getData();
        $data->setOwner($user);

        $property = $this->get('app.property_manager')->persist($data);

        $products = $request->request->all()['property_product'];

        $files = $request->files->all()['property_product'];
        $i = 1;

        foreach ($products as $product){

            $product_create = $this->get("app.property_product_manager")->create();
            $product_create->setProperty($property);

            if(isset($product["name"]))
            $product_create->setName($product["name"]);

            if(isset($product["qty"]))
                $product_create->setCount($product["qty"]);

            if (isset($product["type"])){
                $prodType = $this->get('app.product.type.manager')->find($product["type"]);
                $product_create->setType($prodType);
            }

            if($files[$i]['image']["binaryContent"]){
                $image = $files[$i]['image']["binaryContent"];
                $media = $this->addImage($image);
                $product_create->setImage($media);
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
        $form_product = $this->createForm(PropertyProductType::class);

        $form->handleRequest($request);
        $product = $this->get("app.property_product_manager")->findByProperty($property);

        if (!$form->isValid()) {
            return $this->render(":property:update.html.twig",[
                "form" => $form->createView(),
                "property" => $property,
                "form_product" => $form_product->createView(),
                "product" => $product
            ]);
        }

        /** @var Property $data */
        $data = $form->getData();
        $limit = $data->getType()->getLimitDays();
        $diff = $data->getEnd()->diff($data->getStart());

        if ($diff->days > $limit || $data->getEnd() < $data->getStart()){
            $startDate = new \DateTime($data->getStart()->format("Y-m-d H:i:s"));
            $data->setEnd($startDate->add(new \DateInterval('P'.$limit.'D')));
        }
        $time = date("H");
        $time1 = date("i");
        $data->getEnd()->setTime($time, $time1);
        $data->getStart()->setTime($time, $time1);
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

            if($files['product'.$id.'']["image"]){
                $image = $files['product'.$id.'']["image"];
                $media = $this->addImage($image);
                $product_create->setImage($media);;
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
     *
     * @Security("is_granted('ROLE_USER')")
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
     * @Security("is_granted('ROLE_USER')")
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
     * @param UploadedFile $product
     *
     * @return Media
     */
    private function addImage(UploadedFile $image)
    {
        $media = new Media();
        $mediaManager = $this->get('sonata.media.manager.media');
        $media->setBinaryContent($image);
        $media->setContext('default');
        $media->setProviderName('sonata.media.provider.image');
        $mediaManager->save($media);

        return $media;
    }

    /**
     * @Route("/delete/{id}", name="delete_property")
     * @Security("is_granted('ROLE_USER')")
     * @param Property $property
     * @return mixed
     */
    public function deleteAction(Property $property)
    {
        $user = $this->getUser();
        if($user !== $property->getOwner()){
            return $this->render("error/error.html.twig",[
                "status_text" => "Access denied ",
                "status_code" => 403
            ]);
        }

        $property->setRemoved(true);

        $this->get("app.property_manager")->persist($property);

        return $this->redirect($this->generateUrl("my_list_property"));
    }

    /**
     * @Route("/delete/share/{id}", name="delete_share")
     * @Security("is_granted('ROLE_USER')")
     * @param PriceProduct $priceProduct
     * @return mixed
     */
    public function deletePriceAction(PriceProduct $priceProduct)
    {
        $user = $this->getUser();
        if($user !== $priceProduct->getOwner()){
            return $this->render("error/error.html.twig",[
                "status_text" => "Access denied ",
                "status_code" => 403
            ]);
        }

        $property = $priceProduct->getProperty();

        $price = $this->get("app.price.manager")->findByPropertyOwner($property, $user);

        foreach ($price as $value){
            $this->get("app.price.manager")->remove($value);
        }

        $count = $this->get("app.price.manager")->findByCount($property);

        $property->setPriceCount((int)$count["1"]);
        $this->get("app.property_manager")->persist($property);

        $this->get('app.price_product.manager')->remove($priceProduct);

        return $this->redirect($this->generateUrl("my_share"));
    }
}
