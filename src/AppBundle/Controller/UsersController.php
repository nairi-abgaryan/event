<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use FOS\RestBundle\Controller\FOSRestController;
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
     * @Route("/{id}/", name="retrieve_user")
     * @Security("is_granted('ROLE_USER')")
     *
     * @param User $user
     */
    public function retrieveAction(Request $request, User $user)
    {
        if ($this->getUser() !== $user) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(UserType::class,$user);

        $form->handleRequest($request);

        if ($form->isValid()) {

            /** @var User $data */
            $data = $form->getData();

            $user = $this->get('app.user_manager')->persist($data);

            return $this->render(':show:user.html.twig', [
                'form' => $form->createView(),
                "error" => $form->getErrors(),
                "user" => $user
            ]);
        }

        return $this->render(':show:user.html.twig', [
            'form' => $form->createView(),
            "error" => $form->getErrors(),
            "user" => $user
        ]);
    }

    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request)
    {
        $form = $this->createForm(UserType::class);
        $contact = $this->get("app.contact_manager")->findAll();

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var User $user */
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Welcome '.$user->getEmail());

            return $this->get('security.authentication.guard_handler')
                ->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $this->get('app.security.login_form_authenticator'),
                    'main'
                );
        }

        return $this->render(':show:register.html.twig', [
            'form' => $form->createView(),
            "contact" => $contact,
            "error" => $form->getErrors()
        ]);
    }

    /**
     * Update user.
     *
     * @Route("/{id}/", name="update_user")
     * @Method({"PUT"})
     * @Security("is_granted('ROLE_USER')")
     *
     * @param Request $request
     * @param User    $user
     */
    public function updateAction(Request $request, User $user)
    {
        if ($this->getUser() !== $user) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var User $user */
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Welcome '.$user->getEmail());

            return $this->get('security.authentication.guard_handler')
                ->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $this->get('app.security.login_form_authenticator'),
                    'main'
                );
        }

        /** @var User $data */
        $data = $form->getData();
        $user = $this->get('app.user_manager')->persist($data);
        return $this->render(':show:user.html.twig', [
            'form' => $form->createView(),
            "error" => $form->getErrors(),
            "user" => $user
        ]);
    }

}

