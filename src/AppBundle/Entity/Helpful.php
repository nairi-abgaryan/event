<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="helpful")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HelpRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class Helpful
{
    use TimestampableEntity;

    const FILES_PATH = '/var/www/web/uploads/files/';
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
     * @ORM\Column(type="string", nullable=true)
     * @Serializer\Expose
     */
    private $file;

    /**
     * @var UploadedFile
     */
    private $filePdf;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return mixed
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
        $this->file = $file;
    }

    /**
     * Manages the copying of the file to the relevant place on the server
     */
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFilePdf()) {
            return;
        }

        $this->getFilePdf()->move(
            self::FILES_PATH,
            $this->getFilePdf()->getClientOriginalName()
        );

        $this->filename = $this->getFilePdf()->getClientOriginalName();

        $this->setFile($this->filename );
    }

    /**
     * Lifecycle callback to upload the file to the server
     */
    public function lifecycleFileUpload()
    {
        $this->upload();
    }

}
