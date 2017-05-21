<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Property;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
        $date = new \DateTime();

        if ($property->getEnd() > $date )
        {
            return $this->render("error/error.html.twig",[
                "status_text" => "Access denied ",
                "status_code" => 403
            ]);
        }

        header('Content-type: application/vnd.ms-excel');

        header('Content-Disposition: attachment; filename="file.xls"');

        $price = $this->get("app.price.manager")->findByProperty($property);
        $response =  $this->render("download/download.html.twig",[
            "price" => $price,
            "property" => $property,
        ]);

        $response->setCharset('utf-8');
        iconv("UTF-8", "UTF-8", $response->getContent());
        return $response;
    }

}

