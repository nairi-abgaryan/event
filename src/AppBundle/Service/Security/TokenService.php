<?php

namespace AppBundle\Service\Security;

use AppBundle\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoder;

class TokenService
{
    /**
     * @var JWTEncoder
     */
    private $encoder;

    /**
     * TokenService constructor.
     *
     * @param JWTEncoder $encoder
     */
    public function __construct(JWTEncoder $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param User $user
     *
     * @return string
     */
    public function getTokenForUser(User $user)
    {
        return $this->encoder->encode(['id' => $user->getId()]);
    }
}
