<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;
use Sonata\MediaBundle\Form\Type\MediaType;
use Sonata\MediaBundle\Model\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Table(name="properties_product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PropertyProductRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Serializer\ExclusionPolicy("all")
 */
class PropertyProduct
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Property", inversedBy="product")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $property;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Serializer\Expose
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $count;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ProductType")
     */
    private $type;

    /**
     * @var Media
     *
     * @ORM\ManyToOne(
     *     targetEntity="Application\Sonata\MediaBundle\Entity\Media",
     *     cascade={"persist"},
     *     fetch="LAZY"
     * )
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
     private $priceOwner;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Property
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param Property $property
     */
    public function setProperty($property)
    {
        $this->property = $property;
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
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage(Media $image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param mixed $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return MediaType
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param MediaType $imageFile
     */
    public function setImageFile(MediaType $imageFile)
    {
        $this->imageFile = $imageFile;
    }

    /**
     * @return mixed
     */
    public function getPriceOwner()
    {
        return $this->priceOwner;
    }

    /**
     * @param mixed $priceOwner
     */
    public function setPriceOwner($priceOwner)
    {
        $this->priceOwner = $priceOwner;
    }

    public function __toString()
    {
        return (string)$this->image;
    }
}
