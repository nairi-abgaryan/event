<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(fields={"email"},  message="Ձեր լրացված տվյալը առկա է համակարգում")
 * @UniqueEntity(fields={"tin"},  message="Ձեր լրացված տվյալը առկա է համակարգում")
 * @Serializer\ExclusionPolicy("all")
 */
class User implements UserInterface
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=True)
     *
     * @Serializer\Expose
     * @Serializer\Groups({"Default"})
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     */
    private $password ;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $phoneNumber;


    /**
     * @ORM\Column(type="string")
     */
    private $companyName;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $businessAddress;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $legalAddress;

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    private $tin;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = [];

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        // This way the entity will look modified for Doctrine listener during the password change
        $this->password = null;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        $roles = $this->roles;

        if (!in_array('ROLE_USER', $roles)) {
            $roles[] = 'ROLE_USER';
        }

        return $roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * @param string $role
     */
    public function addRole($role)
    {
        if (!in_array($role, $this->getRoles())) {
            array_push($this->roles, $role);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param mixed $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * @return mixed
     */
    public function getBusinessAddress()
    {
        return $this->businessAddress;
    }

    /**
     * @param mixed $businessAddress
     */
    public function setBusinessAddress($businessAddress)
    {
        $this->businessAddress = $businessAddress;
    }

    /**
     * @return mixed
     */
    public function getLegalAddress()
    {
        return $this->legalAddress;
    }

    /**
     * @param mixed $legalAddress
     */
    public function setLegalAddress($legalAddress)
    {
        $this->legalAddress = $legalAddress;
    }

    /**
     * @return mixed
     */
    public function getTin()
    {
        return $this->tin;
    }

    /**
     * @param mixed $tin
     */
    public function setTin($tin)
    {
        $this->tin = $tin;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return sprintf('%s', $this->getUsername());
    }
}
