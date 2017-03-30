<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="properties_types")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PropertyTypeRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class PropertyType
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
     * @ORM\Column(type="string")
     *
     * @Serializer\Expose
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Image")
     * @ORM\JoinColumn(onDelete="CASCADE")
     *
     * @Serializer\Expose
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $limitDays;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Image $image
     */
    public function setImage(Image $image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getLimitDays()
    {
        return $this->limitDays;
    }

    /**
     * @param mixed $limitDays
     */
    public function setLimitDays($limitDays)
    {
        $this->limitDays = $limitDays;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string)$this->name;
    }
}
