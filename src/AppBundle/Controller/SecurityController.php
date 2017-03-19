<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\LoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
    /**
     * @Route("admin/login/", name="login")
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginType::class, [
            'email' => $lastUsername,
        ]);
        return $this->render('admin/security/login.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }

    /**
     * @Route(path="/admin/logout", name="logout")
     */
    public function logoutAction()
    {
        throw new \Exception('This should not be reached.');
    }
}
