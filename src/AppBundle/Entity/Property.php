<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;
use Sonata\MediaBundle\Model\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Table(name="properties")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PropertyRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class Property
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(onDelete="CASCADE")
     *
     * @Serializer\Expose
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PropertyType")
     * @ORM\JoinColumn(onDelete="CASCADE")
     *
     * @Serializer\Expose
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PropertyCategory")
     * @ORM\JoinColumn(onDelete="CASCADE")
     *
     * @Serializer\Expose
     */
    private $category;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Serializer\Expose
     */
    private $financing;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Serializer\Expose
     */
    private $insurance;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $shipment;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Serializer\Expose
     */
    private $advance;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Serializer\Expose
     */
    private $budget;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Serializer\Expose
     */
    private $overview;


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
    private $file;

    /**
     * @var UploadedFile
     */
    private $filePdf;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $removed = false;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priceCount;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $actived = false;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $propertyType;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PropertyProduct", mappedBy="property")
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $product;

    public function __construct()
    {
        $this->product = new ArrayCollection();
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduct()
    {
        return $this->product ;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return PropertyType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param PropertyType $type
     */
    public function setType(PropertyType $type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
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
    public function getInsurance()
    {
        return $this->insurance;
    }

    /**
     * @param mixed $insurance
     */
    public function setInsurance($insurance)
    {
        $this->insurance = $insurance;
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
     * @return mixed
     */
    public function getAdvance()
    {
        return $this->advance;
    }

    /**
     * @param mixed $advance
     */
    public function setAdvance($advance)
    {
        $this->advance = $advance;
    }

    /**
     * @return mixed
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * @param mixed $budget
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;
    }

    /**
     * @return mixed
     */
    public function getOverview()
    {
        return $this->overview;
    }

    /**
     * @param mixed $overview
     */
    public function setOverview($overview)
    {
        $this->overview = $overview;
    }

    /**
     * @return Media
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param Media $file
     */
    public function setFile(Media $file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getFilePdf()
    {
        return $this->filePdf;
    }

    /**
     * @param mixed $filePdf
     */
    public function setFilePdf(UploadedFile $filePdf)
    {
        $this->filePdf = $filePdf;
    }

    /**
     * @return mixed
     */
    public function getRemoved()
    {
        return $this->removed;
    }

    /**
     * @param mixed $removed
     */
    public function setRemoved($removed)
    {
        $this->removed = $removed;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param mixed $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * @return mixed
     */
    public function getPriceCount()
    {
        return $this->priceCount;
    }

    /**
     * @param mixed $priceCount
     */
    public function setPriceCount($priceCount)
    {
        $this->priceCount = $priceCount;
    }

    /**
     * @return mixed
     */
    public function getActived()
    {
        return $this->actived;
    }

    /**
     * @param mixed $actived
     */
    public function setActived($actived)
    {
        $this->actived = $actived;
    }

    /**
     * @return mixed
     */
    public function getPropertyType()
    {
        return $this->propertyType;
    }

    /**
     * @param mixed $propertyType
     */
    public function setPropertyType($propertyType)
    {
        $this->propertyType = $propertyType;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string)$this->id;
    }
}

