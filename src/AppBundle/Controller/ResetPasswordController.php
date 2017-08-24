<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Token;
use AppBundle\Entity\User;
use AppBundle\Form\Type\EmailFormType;
use AppBundle\Form\Type\PasswordType;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ResetPasswordController extends FOSRestController
{

    /**
     * @Route("/reset/", name="reset_password")
     * @param Request $request
     * @return mixed
     */
    public function pastAction(Request $request)
    {
        $form = $this->createForm(EmailFormType::class);
        $form->handleRequest($request);

        return $this->render(':password:resetPassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/password/", name="reset_password_email")
     *
     * @param Request $request
     * @return mixed
     */
    public function subscribeAction(Request $request)
    {
        $form = $this->createForm(EmailFormType::class);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return new Response("invalid email");
        }
        /** @var User $user */
        $user = $form->getData()['email'];
        $token = bin2hex(random_bytes(32));

        /** @var Token $data */
        $newToken = $this->get("app.token")->create();
        $newToken->setOwner($user);
        $newToken->setToken($token);
        $this->get("app.token")->persist($newToken);

        $link = "http://uno.dev/reset-password/$token/";

        $message =  $this->renderView(':mail:reset.html.twig',[
                'action_url' => $link,
                'name' => $user->getName()
            ]
        );

        $email = $this->get("app.mailer_service")->sendMail($message, $user->getEmail());

        return new Response($email);
    }


    /**
     * Reset password page uno
     *
     * @Route("/reset-password/{token}/", name="api.reset_password")
     *
     * @param Request $request
     * @return mixed
     */
    public function retrieveAction($token, Request $request)
    {

        $token = $this->get("app.token")->findOneBy(['token' => $token]);

        if(!$token){
            return $this->render('error/error404.html.twig') ;
        }

        $form = $this->createForm(PasswordType::class);

        return $this->render(":password:reset.html.twig", [
            "form" => $form->createView(),
            "token" => $token
        ]);
    }

    /**
     *
     * @Route("/reset-user-password/", name="web.reset")
     *
     * @return mixed
     * @param Request $request
     */
    public function resetAction(Request $request){

        $form = $this->createForm(PasswordType::class);
        $form->submit($request->request->all()['password'], false);

        if(!$form->isValid()){
            return $this->render(":password:reset.html.twig", [
                "form" => $form->createView(),
                "token" => $request->request->all()['token']
            ]);
        }

        /** @var PasswordType $data */
        $data = $form->getData();
        $token = $this->get("app.token")->findOneBy(['token' => $request->request->all()['token']]);

        $user = $token->getOwner();
        $user->setPlainPassword($data['password']);
        $this->get("app.user_manager")->persist($user);
        $this->get("app.token")->remove($token);

        return $this->redirectToRoute("home");
    }
}
