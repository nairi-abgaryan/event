<?php

namespace AppBundle\Service\Helper;

use Application\Sonata\MediaBundle\Entity\Media;
use Sonata\MediaBundle\Provider\FileProvider;
use Sonata\MediaBundle\Twig\Extension\MediaExtension;

class AdminHelper
{
    /**
     * @var MediaExtension
     */
    private $mediaExtension;

    /**
     * @var FileProvider
     */
    private $fileProvider;

    /**
     * AdminHelper constructor.
     *
     * @param MediaExtension $mediaExtension
     * @param FileProvider   $fileProvider
     */
    public function __construct(MediaExtension $mediaExtension, FileProvider $fileProvider)
    {
        $this->mediaExtension = $mediaExtension;
        $this->fileProvider = $fileProvider;
    }

    /**
     * @param Media $media
     *
     * @return string
     */
    public function getPhotoHelper(Media $media = null)
    {
        if ($media) {
            return '<img src="' . $this->mediaExtension->path($media, 'small') . '"/>';
        }

        return '';
    }

    /**
     * @param Media $media
     *
     * @return string
     */
    public function getFileHelper(Media $media = null)
    {
        if ($media) {
            $format = $this->fileProvider->getFormatName($media, 'reference');
            $url = $this->fileProvider->generatePublicUrl($media, $format);

            return '<a target="_blank" href="' . $url . '">Download</a>';
        }

        return $media;
    }
}
