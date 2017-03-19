<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;

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
     * @ORM\Column(type="integer")
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
     * @ORM\Column(type="string")
     */
    private $shipment;

    /**
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     */
    private $advance;

    /**
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     */
    private $budget;

    /**
     * @ORM\Column(type="text")
     *
     * @Serializer\Expose
     */
    private $overview;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\File")
     * @ORM\JoinColumn(onDelete="CASCADE")
     *
     * @Serializer\Expose
     */
    private $file;

    /**
     * @ORM\Column(type="integer")
     */
    private $active;

    /**
     * @ORM\Column(type="date")
     */
    private $start;

    /**
     * @ORM\Column(type="date")
     */
    private $end;

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
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->$file = $file;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
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
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string)$this;
    }
}

