<?php

namespace AppBundle\Service\Manager;

use AppBundle\Entity\File;
use AppBundle\Entity\Image;
use AppBundle\Entity\User;
use AppBundle\Repository\FileRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManager
{
    /**
     * @var FileRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var string
     */
    private $uploadsDir;

    /**
     * ImageManager constructor.
     *
     * @param FileRepository $repository
     * @param EntityManager   $em
     * @param string          $rootDir
     */
    public function __construct(FileRepository $repository, EntityManager $em, $rootDir)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->uploadsDir = $rootDir . '/../web/uploads/files/';
    }

    /**
     * @param $id
     *
     * @return object|null|File
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $criteria
     *
     * @return object|null|File
     */
    public function findOneBy($criteria = [])
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAll()
    {
        $qb = $this->repository->createQueryBuilder('file');

        return $qb;
    }

    /**
     * @return File
     */
    public function create()
    {
        return new File();
    }

    /**
     * @param UploadedFile $file
     * @param User         $owner
     * @param Image        $oldImage
     *
     * @return Image
     */
    public function upload(UploadedFile $file, User $owner, Image $oldImage = null)
    {
        $image = ($oldImage) ? $oldImage : $this->create();

        if ($image->getPath()) {
            unlink($this->uploadsDir . $image->getPath());
        }

        $image->setOwner($owner);
        $path = md5(uniqid($file->getClientOriginalName(), true)) . ".jpg";
        $file->move($this->uploadsDir, $path);
        $image->setPath($path);
        return $this->persist($image);
    }

    /**
     * @param Image $image
     */
    public function uploadFromAdmin(Image $image)
    {
        $oldImage = ($image->getPath()) ? $image : null;
        $image->setPath($this->upload($image->getFile(), $image->getOwner(), $oldImage)->getPath());
    }

    /**
     * @param Image $image
     *
     * @return Image
     */
    public function persist(Image $image)
    {
        $this->em->persist($image);
        $this->em->flush();

        return $image;
    }
}
