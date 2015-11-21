<?php

namespace PinterestLike\CoreBundle\Library;

use Imagine\Gd\Imagine;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\File\File;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

abstract class UploadableImage
{
    abstract public function getUploadDir();

    public function generateNewFileName()
    {
        return sha1(uniqid(mt_rand(), true)) . '.' . $this->file->guessExtension();
    }

    public function doUpload($fileType = 'imagePath')
    {
        if (null === $this->file) {
            return;
        }
        $image = $this->file->getPathname();
        $imageDetails = getimagesize($image);

        $orientation = null;
        $originalImage = null;

        // get the image type
        switch ($imageDetails['mime']) {
            case 'image/pjpeg':
            case 'image/jpeg':
            case 'image/jpg':
                $exif = exif_read_data($image);
                if (isset($exif['Orientation'])) {
                    $orientation = $exif['Orientation']; // yes, that's a capital O
                }
                $originalImage = imagecreatefromjpeg($image);
                break;
            case 'image/png':
                $originalImage = imagecreatefrompng($image);
                break;
            default:
                throw new \Exception("This file doesn't appear to be an image: ".$imageDetails['mime']);
        }

        /*
            exif orientation codes from http://sylvana.net/jpegcrop/exif_orientation.html
            Value    0th Row      0th Column
            1        top          left side (normal)
            2        top          right side
            3        bottom       right side (rotated 180)
            4        bottom       left side
            5        left side    top
            6        right side   top (rotated 90)
            7        right side   bottom
            8        left side    bottom (rotated -90)

            Can't be bothered dealing with mirror images so will ignore
            (no flip functionality in GD so pixel by pixel ball-ache required to implement)
         */
        switch ($orientation) {
            case 3:
                $originalImage = imagerotate($originalImage, 180, 0);
                break;
            case 6:
                $originalImage = imagerotate($originalImage, -90, 0);
                break;
            case 8:
                $originalImage = imagerotate($originalImage, 90, 0);
                break;
        }

        // save it
        switch ($imageDetails['mime']) {
            case 'image/pjpeg':
            case 'image/jpeg':
            case 'image/jpg':
                imagejpeg($originalImage, $image, 75);
                break;
            case 'image/png':
                imagepng($originalImage, $image);
                break;
        }

        $this->file->move($this->getUploadRootDir(), $this->$fileType);
        return;
    }

    public function getAbsolutePath()
    {
        return null === $this->imagePath ? null : $this->getUploadRootDir().'/'.$this->imagePath;
    }

    public function getWebPath()
    {
        // perhaps it should return a path beginning with a slash?
        return null === $this->imagePath ? null : $this->getUploadDir().'/'.$this->imagePath;
    }

    public function getThumbnailUrl($imagineFilter = 'message_image_thumbnail')
    {
        if (!$this->imagePath) {
            return null;
        }

        return sprintf('/images/cache/%s/%s', $imagineFilter, $this->getWebPath());
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

}
