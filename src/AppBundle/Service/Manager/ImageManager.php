<?php

namespace AppBundle\Service\Manager;

use AppBundle\Entity\Image;
use AppBundle\Entity\User;
use AppBundle\Repository\ImageRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageManager
{
    /**
     * @var ImageRepository
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
     * @param ImageRepository $repository
     * @param EntityManager   $em
     * @param string          $rootDir
     */
    public function __construct(ImageRepository $repository, EntityManager $em, $rootDir)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->uploadsDir = $rootDir . '/../web/uploads/images/';
    }

    /**
     * @param $id
     *
     * @return object|null|Image
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $criteria
     *
     * @return object|null|Image
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
        $qb = $this->repository->createQueryBuilder('image');

        return $qb;
    }

    /**
     * @return Image
     */
    public function create()
    {
        return new Image();
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
