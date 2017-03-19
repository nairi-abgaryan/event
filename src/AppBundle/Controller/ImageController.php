<?php

namespace AppBundle\Controller\Api;

use League\Glide\Responses\SymfonyResponseFactory;
use League\Glide\ServerFactory;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/images")
 */
class ImageController extends Controller
{
    /**
     * Retrieve image.
     *
     * @Route("/{path}/", name="api.retrieve_image")
     * @Method({"GET"})
     * @ApiDoc(section="Images")
     *
     * @param $path
     */
    public function retrieveAction($path)
    {
        $uploadsDir = $this->getParameter('kernel.root_dir') . '/../web/uploads/images/';
        $cacheDir = $this->getParameter('kernel.root_dir') . '/../web/uploads/images/cache/';

        // Setup Glide server
        $server = ServerFactory::create([
            'source' => $uploadsDir,
            'cache' => $cacheDir,
            'response' => new SymfonyResponseFactory()
        ]);

        // But, a better approach is to use information from the request
        $server->outputImage($path, $_GET);
    }
}
