<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Favorite;
use AppBundle\Entity\Property;
use AppBundle\Form\Type\FavoriteType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/favorites")
 */
class FavoriteController extends FOSRestController
{
    /**
     * Create favorite.
     *
     * @Route("/", name="api.create_favorite")
     * @Method({"POST"})
     *
     * @ApiDoc(
     *     section="Favorites",
     *     input={
     *         "class"="AppBundle\Form\Type\FavoriteType",
     *          "name"=""
     *      }
     * )
     *
     * @return View|Response
     */
    public function createAction(Request $request){

        $user = $this->getUser();

        $form = $this->createForm(FavoriteType::class);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return View::create($form, 400);
        }

        /** @var Favorite $data */
        $data = $form->getData();
        $property = $data->getProperty();
        $favoriteCheck = $this->get("app.favorite_manager")->findOneBy(array('property'=>$property,"owner" => $user));

        if(empty($favoriteCheck)){

            $favorite = $this->get("app.favorite_manager")->create();

            $favorite->setOwner($user);
            $favorite->setProperty($property);

            $favoriteSave = $this->get("app.favorite_manager")->persist($favorite);
            $view = $this->view($favoriteSave,201);

            return $this->handleView($view);
        }else{
            $view = $this->view(['favorites' => "null"],200);

            return $this->handleView($view);
        }
    }

    /**
     * List user favorites
     *
     * @Route("/", name="api.list_favorites")
     * @Method({"GET"})
     *
     * @ApiDoc(
     *     section="Favorites"
     * )
     *
     * @return View|Response
     */
    public function listAction(Request $request)
    {
        $user_id = $this->getUser()->getId();

        $favorites = $this->get("app.favorite_manager")->findBy($user_id);

        $paginatedItems = $this->get('app.pagination_factory')
            ->createCollection($favorites, $request, 'api.list_favorite');

        $view = $this->view($paginatedItems, 200);

        return $this->handleView($view);
    }

    /**
     * Delete favorite.
     *
     * @Route("/{id}", name="api.delete_favorite")
     * @Method({"DELETE"})
     *
     * @ApiDoc(
     *     section="Favorites"
     * )
     *
     * @param Property $property
     *
     * @return View|Response
     */
    public function deleteAction(Property $property)
    {
        $user = $this->getUser();
        $favorite = $this->get("app.favorite_manager")->findOneBy(array("property"=>$property,"owner"=>$user));

        if(!empty($favorite)){
            $item = $this->get("app.favorite_manager")->remove($favorite);
            $status = 202;
        }else{
            $item = 'No Content';
            $status = 204;
        }

        $view = $this->view(['favorites' => $item],$status);

        return $this->handleView($view);
    }
}

