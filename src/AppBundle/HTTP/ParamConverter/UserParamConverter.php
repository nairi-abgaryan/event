<?php

namespace AppBundle\HTTP\ParamConverter;

use AppBundle\Entity\User;
use AppBundle\Service\Manager\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserParamConverter implements ParamConverterInterface
{
    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * UserParamConverter constructor.
     *
     * @param UserManager  $userManager
     * @param TokenStorage $tokenStorage
     */
    public function __construct(UserManager $userManager, TokenStorage $tokenStorage)
    {
        $this->userManager = $userManager;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Stores the object in the request.
     *
     * @param Request        $request       The request
     * @param ParamConverter $configuration Contains the name, class and options of the object
     *
     * @return bool True if the object has been successfully set, else false
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $id = $request->attributes->get('id');

        /** @var TokenInterface $token */
        $token = $this->tokenStorage->getToken();

        if (!$id || $id === '') {
            throw new NotFoundHttpException();
        }

        if ($id !== 'me') {
            $user = $this->userManager->findOneBy(['id' => $id]);
        } else {
            /** @var User $user */
            $user = $token->getUser();
        }

        if (!$user) {
            throw new NotFoundHttpException();
        }

        $request->attributes->set($configuration->getName(), $user);

        return true;
    }

    /**
     * Checks if the object is supported.
     *
     * @param ParamConverter $configuration Should be an instance of ParamConverter
     *
     * @return bool True if the object is supported, else false
     */
    public function supports(ParamConverter $configuration)
    {
        return 'AppBundle\Entity\User' === $configuration->getClass();
    }
}
