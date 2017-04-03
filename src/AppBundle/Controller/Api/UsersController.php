<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/users")
 */
class UsersController extends FOSRestController
{
    /**
     * Retrieve user.
     *
     * @Route("/{id}/", name="api.retrieve_user")
     * @Method({"GET"})
     * @Security("is_granted('ROLE_USER')")
     *
     * @ApiDoc(section="Users")
     *
     * @param User $user
     *
     * @return Response
     */
    public function retrieveAction(User $user)
    {
        $view = $this->view($user, 200);

        return $this->handleView($view);
    }

    /**
     * Create user.
     *
     * @Route("/", name="api.create_user")
     * @Method({"POST"})
     *
     * @ApiDoc(
     *     section="Users",
     *     input={
     *          "class"="AppBundle\Form\Type\UserType",
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
        $form = $this->createForm(UserType::class);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return View::create($form, 400);
        }

        /** @var User $data */
        $data = $form->getData();

        $user = $this->get('app.user_manager')->persist($data);

        $token = $this->get('app.token_service')->getTokenForUser($user);
        $view = $this->view(['token' => $token], 201);

        return $this->handleView($view);
    }

    /**
     * Update user.
     *
     * @Route("/{id}/", name="api.update_user")
     * @Method({"PUT"})
     * @Security("is_granted('ROLE_USER')")
     *
     * @ApiDoc(
     *     section="Users",
     *     input={
     *          "class"="AppBundle\Form\Type\UserType",
     *          "name"=""
     *     }
     * )
     *
     * @param Request $request
     * @param User    $user
     *
     * @return View|Response
     */
    public function updateAction(Request $request, User $user)
    {
        if ($this->getUser() !== $user) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(UserType::class, $user);
        $form->submit($request->request->all(), false);

        if (!$form->isValid()) {
            return View::create($form, 400);
        }

        /** @var User $data */
        $data = $form->getData();
        $user = $this->get('app.user_manager')->persist($data);
        $view = $this->view($user, 200);

        return $this->handleView($view);
    }

}

