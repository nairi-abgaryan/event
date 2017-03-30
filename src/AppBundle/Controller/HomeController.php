<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\LoginType;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/")
 */
class HomeController extends  FOSRestController
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction(){

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginType::class, [
            'email' => $lastUsername,
        ]);
        $news = $this->get("app.news_manager")->findAll();
        $contact = $this->get("app.contact_manager")->findAll();

        return $this->render(":show:home.html.twig", [
            "news" => $news,
            "contact" => $contact,
            "form" => $form->createView(),
            "error" => $error
        ]);
    }

    /**
     * @Route(path="/logout", name="logout")
     */
    public function logoutAction()
    {
        throw new \Exception('This should not be reached.');
    }
}
