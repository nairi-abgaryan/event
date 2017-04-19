<?php

namespace AppBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Media;
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
     * @var Media
     *
     * @ORM\ManyToOne(
     *     targetEntity="Application\Sonata\MediaBundle\Entity\Media",
     *     cascade={"persist"},
     *     fetch="LAZY"
     *  )
     *
     */
    private $image=null;

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
     * @return Media
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Media $image
     */
    public function setImage(Media $image=null)
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
