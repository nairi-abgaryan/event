<?php

namespace AppBundle\Controller\Api;

use AppBundle\Form\Type\LoginType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/auth")
 */
class AuthController extends FOSRestController
{
    /**
     * Login with email and password.
     *
     * @Route("/login/", name="api.auth_login")
     * @Method({"POST"})
     *
     * @ApiDoc(
     *     section="Auth",
     *     input={
     *          "class"="AppBundle\Form\Type\LoginType",
     *          "name"=""
     *     }
     * )
     *
     * @param Request $request
     *
     * @return View|Response
     */
    public function loginAction(Request $request)
    {
        $form = $this->createForm(LoginType::class);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return View::create($form, 400);
        }

        $data = $form->getData();

        $email = $data['email'];
        $password = $data['password'];

        $passwordEncoder = $this->get('security.password_encoder');
        $user = $this->get('app.user_manager')->findOneBy(['email' => $email]);

        if (!$user) {
            $view = $this->view(['error' => 'Invalid credentials.'], 200);

            return $this->handleView($view);
        }

        $validPassword = $passwordEncoder->isPasswordValid($user, $password);

        if (!$validPassword) {
            $view = $this->view(['error' => 'Invalid credentials.'], 200);

            return $this->handleView($view);
        }

        $token = $this->get('app.token_service')->getTokenForUser($user);
        $view = $this->view(['token' => $token], 200);

        return $this->handleView($view);
    }
}
