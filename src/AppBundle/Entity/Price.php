<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Table(name="price")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PriceRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Serializer\ExclusionPolicy("all")
 */
class Price
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Property")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @Serializer\Expose
     */
    private $property;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PropertyProduct")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @Serializer\Expose
     */
    private $product;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @Serializer\Expose
     */
    private $owner;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string")
     */
    private $financing;

    /**
     * @ORM\Column(type="boolean")
     */
    private $shipment;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\File")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=true)
     * @Serializer\Expose
     */
    private $file;

    /**
     * @var UploadedFile
     */
    private $filePdf;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
     private $established;

    /**
     * @return mixed
     */
    public function getEstablished()
    {
        return $this->established;
    }

    /**
     * @param mixed $established
     */
    public function setEstablished($established)
    {
        $this->established = $established;
    }

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
    public function setProperty(Property $property)
    {
        $this->property = $property;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;
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
     * @return mixed
     */
    public function getFinancing()
    {
        return $this->financing;
    }

    /**
     * @param mixed $financing
     */
    public function setFinancing($financing)
    {
        $this->financing = $financing;
    }

    /**
     * @return mixed
     */
    public function getShipment()
    {
        return $this->shipment;
    }

    /**
     * @param mixed $shipment
     */
    public function setShipment($shipment)
    {
        $this->shipment = $shipment;
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param File $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return UploadedFile
     */
    public function getFilePdf()
    {
        return $this->filePdf;
    }

    /**
     * @param UploadedFile $filePdf
     */
    public function setFilePdf($filePdf)
    {
        $this->filePdf = $filePdf;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this;
    }
}
