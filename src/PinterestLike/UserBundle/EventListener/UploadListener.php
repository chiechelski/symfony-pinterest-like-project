<?php

namespace PinterestLike\UserBundle\EventListener;

use PinterestLike\VendorBundle\Entity\VendorImage;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Oneup\UploaderBundle\Event\PostPersistEvent;

class UploadListener
{
    public function __construct($doctrine, $container)
    {
        $this->doctrine = $doctrine;
        $this->container = $container;
    }

    public function onUpload(PostPersistEvent $event)
    {
        $entityManager = $this->doctrine->getManager();
        $response = $event->getResponse();
        $request = $event->getRequest();
        $type = $request->get('type');
        $file = $event->getFile();

        $vendor = $user = $this->container->get('security.token_storage')->getToken()->getUser()->getVendor();

        $result = [];

        if (!empty($file)) {
            $vendorImage = new VendorImage();
            $vendorImage->setVendor($vendor);
            $vendorImage->setName($_FILES['files']['name'][0]);
            $vendorImage->setFile($file);
            $vendorImage->setCreatedAt(new \DateTime());
            $vendorImage->preUpload();
            $vendorImage->upload();
            $entityManager->persist($vendorImage);
            $entityManager->flush();

            $response['imageId'] = $vendorImage->getId();
            $response['imageSrc'] = '/' . $vendorImage->getWebPath();
        }

        // return new JsonResponse(array('result' => 'saasa'));

        return $response;
    }
}
