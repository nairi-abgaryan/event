<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/contact")
 */
class ContactController extends FOSRestController
{

    /**
     * List user States
     *
     * @Route("/footer", name="list_contact_footer")
     * @Method({"GET"})
     *
     * @return View|Response
     */
    public function footerAction()
    {
        $contact = $this->get("app.contact_manager")->findAll();

        return $this->render(':default:footer.html.twig',[
            "contact" => $contact
        ]);
    }


    /**
     * List user States
     *
     * @Route("/", name="list_contact")
     * @Method({"GET"})
     *
     * @return View|Response
     */
    public function contactAction()
    {
        $contact = $this->get("app.contact_manager")->findAll();

        return $this->render(':show:contact.html.twig',[
            "contact" => $contact
        ]);
    }

    /**
     * List user States
     *
     * @Route("/send/", name="send_contact")
     * @Method({"POST"})
     *
     * @return View|Response
     */
    public function sendAction(Request $request)
    {
        $contact = $this->get("app.contact_manager")->find(1);
        $request = $request->request->all();
        $message = "<html>
                        <body>
                            <h3>" . $request["name"] . "<h3>
                            <h3>" . $request['email'] . "<h3>
                            ".$request['message']."
                        </body>
                    </html>";

        $this->get("app.mailer_service")->sendMail($message, $contact->getAdminEmail());

        return $this->render(":show:contact.html.twig",[
            "contact" => $contact
        ]);
    }
}

