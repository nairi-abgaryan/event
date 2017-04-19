<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Property;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Knp\Snappy\Pdf;

/**
 * @Route("/downloads")
 */
class DownloadController extends FOSRestController
{
    /**
     * @Route("/{id}", name="download_all")
     *
     * @param Property $property
     * @return mixed
     */
    public function downloadAllAction(Property $property)
    {

        $user = $this->getUser();
        if($user !== $property->getOwner() ){
            return $this->render("error/error.html.twig",[
                "status_text" => "Access denied ",
                "status_code" => 403
            ]);
        }

        $price = $this->get("app.price.manager")->findByProperty($property);
        return $this->render("download/download.html.twig",[
            "price" => $price,
            "property" => $property,
        ]);
    }

}

