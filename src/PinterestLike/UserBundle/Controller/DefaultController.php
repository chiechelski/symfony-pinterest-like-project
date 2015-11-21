<?php

namespace PinterestLike\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use PinterestLike\UserBundle\Form\Type\UserStep2RegistrationFormType;

use PinterestLike\UserBundle\Entity\UserAlbum;
use PinterestLike\UserBundle\Entity\UserAlbumMedia;
use PinterestLike\VendorBundle\Entity\Vendor;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PinterestLikeUserBundle:Default:index.html.twig', array('name' => $name));
    }

    /**
     * @Route("/user/media/save/{type}/{id}", name="user_save_media")
     */
    public function saveMediaAction(Request $request, $type, $id)
    {
        $manager = $this->getDoctrine()->getManager();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        // need to login first
        if (!$this->get('security.context')->isGranted('ROLE_USER')) {
            return $this->redirect(
                $this->generateUrl("login", array('popup' => $request->query->get('popup', 0)))
            );
        }

        if ($type == 'image') {
            $imageRepository = $manager->getRepository('PinterestLikeVendorBundle:VendorImage');
            $entity = $imageRepository->find($id);
        }
        else {
            $videoRepository = $manager->getRepository('PinterestLikeVendorBundle:VendorVideo');
            $entity = $videoRepository->find($id);
        }

        $vendor = $entity->getVendor();
        return $this->render('PinterestLikeUserBundle:Default:save.media.html.twig',
                array(
                    'type' => $type,
                    'id' => $id,
                    'entity' => $entity,
                    'user' => $user,
                    'vendor' => $vendor
                )
            );
    }

    /**
     * Add Media to Album
     *
     * @Route("/user/media/add/{type}/{id}", name="user_add_media_to_album")
     */
    public function addMediaToAlbumAction(Request $request, $type, $id)
    {
        $manager = $this->getDoctrine()->getManager();

        if (!$this->get('security.context')->isGranted('ROLE_USER')) {
            return JsonResponse(array('result' => []));
        }

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $userAlbumMedia = new UserAlbumMedia();

        // set album
        $albumId = $request->get('album');
        $albumRepository = $manager->getRepository('PinterestLikeUserBundle:UserAlbum');
        $album = $albumRepository->find($albumId);
        $userAlbumMedia->setUserAlbum($album);

        // set media
        if ($type == 'image') {
            $imageRepository = $manager->getRepository('PinterestLikeVendorBundle:VendorImage');
            $entity = $imageRepository->find($id);
            $userAlbumMedia->setImage($entity);
        }
        else {
            $videoRepository = $manager->getRepository('PinterestLikeVendorBundle:VendorVideo');
            $entity = $videoRepository->find($id);
            $userAlbumMedia->setVideo($entity);
        }

        // set note
        $note = $request->get('note');
        $userAlbumMedia->setDescription($note);

        $userAlbumMedia->setCreatedAt(new \DateTime());

        $manager->persist($userAlbumMedia);
        $manager->flush();

        $response = [];
        $response['album-media']['id'] = $userAlbumMedia->getId();

        return new JsonResponse(array('result' => $response));
    }

    /**
     * Create an user album
     *
     * @Route("/user/create-album", name="user_create_album")
     */
    public function createAlbum(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $album = $request->get('album');

        if (!$this->get('security.context')->isGranted('ROLE_USER')) {
            return JsonResponse(array('result' => []));
        }

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $userAlbum = new UserAlbum();
        $userAlbum->setName($album);
        $userAlbum->setCreatedAt(new \DateTime());
        $userAlbum->setUpdatedAt(new \DateTime());
        $userAlbum->setUser($user);

        $manager->persist($userAlbum);
        $manager->flush();

        $response = [];
        $response['album']['id'] = $userAlbum->getId();
        $response['album']['name'] = $userAlbum->getName();

        return new JsonResponse(array('result' => $response));
    }

    /**
     * User Settings
     *
     * @Route("/user/settings", name="user_settings")
     */
    public function userSettingsAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $form = $this->createForm(
            new UserStep2RegistrationFormType(),
            $user
        );

        $form->handleRequest($request);
        if ($form->isValid()) {
            $postData = $this->getRequest()->request->get('user');
            if ($form->get('weddingDate')->getData()) {
                if ($user->getWedding()) {
                    $wedding = $user->getWedding();
                }
                else {
                    $wedding = new Wedding();
                }

                $wedding->setWeddingDate($form->get('weddingDate')->getData());

                $user->setWedding($wedding);
            }

            $manager->persist($form->getData());
            $manager->flush();

            $this->setFlash('success', 'User has been succesfully updated');
        }

        return $this->container->get('templating')->renderResponse(
            'PinterestLikeUserBundle:Default:user.settings.html.twig',
            array(
                'form' => $form->createView(),
                'user'   => $user
            )
        );
    }

    /**
     *
     * @Route("/user/albums", name="user_albums")
     */
    public function userAlbums()
    {
        $manager = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $this->container->get('templating')->renderResponse(
            'PinterestLikeUserBundle:Default:user.albums.html.twig',
            array(
                'user'   => $user
            )
        );
    }

    /**
     *
     * @Route("/user/vendors", name="user_vendors")
     */
    public function userVendors()
    {
        $manager = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $this->container->get('templating')->renderResponse(
            'PinterestLikeUserBundle:Default:user.vendors.html.twig',
            array(
                'user'   => $user
            )
        );
    }

    /**
     * TODO: CREATE DEFAULT CONTROLLER ON CORE AND ADD THIS TO IT
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->container->get('session')->getFlashBag()->set($action, $value);
    }
}
