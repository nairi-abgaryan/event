<?php

namespace AppBundle\Service\Security;

use AppBundle\Form\Type\LoginType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class AdminLoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var UserPasswordEncoder
     */
    private $passwordEncoder;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var array
     */
    private $pathSegments = [];

    /**
     * LoginFormAuthenticator constructor.
     *
     * @param FormFactoryInterface $formFactory
     * @param EntityManager        $em
     * @param RouterInterface      $router
     * @param UserPasswordEncoder  $passwordEncoder
     * @param RequestStack         $requestStack
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        EntityManager $em,
        RouterInterface $router,
        UserPasswordEncoder $passwordEncoder,
        RequestStack $requestStack
    ) {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
        $this->requestStack = $requestStack;

        $request = $this->requestStack->getCurrentRequest();

        if ($request) {
            $this->pathSegments = explode('/', $request->getPathInfo());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        $request->getPathInfo() === '/admin/login' && $request->isMethod('POST');
        $form = $this->formFactory->create(LoginType::class);

        $form->handleRequest($request);
        $data = $form->getData();

        $request->getSession()->set(
            Security::LAST_USERNAME,
            $data['email']
        );

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $this->em->getRepository('AppBundle:User')
            ->findOneBy(['email' => $credentials['email']]);
    }

    /**
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        $password = $credentials['password'];

        if ($this->passwordEncoder->isPasswordValid($user, $password)) {
            return true;
        }

        return "invalid Cridanshial";
    }

    /**
     * {@inheritdoc}
     */
    protected function getLoginUrl()
    {
        return $this->router->generate('login');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultSuccessRedirectURL()
    {
        return $this->router->generate('sonata_admin_dashboard');
    }
}
