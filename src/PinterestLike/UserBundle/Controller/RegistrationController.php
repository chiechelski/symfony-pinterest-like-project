<?php

namespace PinterestLike\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\HttpFoundation\Request;

use PinterestLike\UserBundle\Form\Type\UserStep2RegistrationFormType;
use PinterestLike\UserBundle\Form\Type\VendorStep2RegistrationFormType;
use PinterestLike\VendorBundle\Form\Type\VendorMediaFormType;
use PinterestLike\VendorBundle\Entity\Vendor;
use PinterestLike\VendorBundle\Entity\VendorImage;
use PinterestLike\VendorBundle\Entity\VendorVideo;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {
        $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

        // move this later - REFACTORY
        $formData = $request->request->all();
        if (!empty($formData['fos_user_registration_form']['email'])) {
            $formData['fos_user_registration_form']['username'] = $formData['fos_user_registration_form']['email'];

        }
        $request->request->replace($formData);

        $process = $formHandler->process($confirmationEnabled);
        // print_r($process);

        if ($process) {
            $user = $form->getData();

            $authUser = false;
            if ($confirmationEnabled) {
                $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $route = 'fos_user_registration_check_email';
            } else {
                $authUser = true;
                $route = 'fos_user_registration_confirmed';
            }

            $this->setFlash('success', 'User has been succesfully created');
            $url = $this->container->get('router')->generate($route);
            $response = new RedirectResponse($url);

            if ($authUser) {
                $this->authenticateUser($user, $response);
            }

            return $response;
        }

        return $this->container->get('templating')->renderResponse('PinterestLikeUserBundle:Registration:register.step1.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/register/step1/form/{type}", name="register_step1")
     */
    public function registerFormAction(Request $request, $type)
    {
        $form = $this->container->get('fos_user.registration.form');
        return $this->container->get('templating')->renderResponse('PinterestLikeUserBundle:Registration:register.step1.html.twig', array(
            'form' => $form->createView(),
            'type' => $type
        ));
    }

    /**
     * Authenticate a user with Symfony Security
     *
     * @param \FOS\UserBundle\Model\UserInterface        $user
     * @param \Symfony\Component\HttpFoundation\Response $response
     */
    protected function authenticateUser(UserInterface $user, Response $response)
    {
        try {
            $this->container->get('fos_user.security.login_manager')->loginUser(
                $this->container->getParameter('fos_user.firewall_name'),
                $user,
                $response);
        } catch (AccountStatusException $ex) {
            // We simply do not authenticate users which do not pass the user
            // checker (not enabled, expired, etc.).
        }
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

    /**
     * @Route("/register/confirmed", name="register_confirmed")
     */
    public function registerConfirmedAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        return $this->redirect(
            $this->generateUrl(
                "register_" . $user->getRegistrationStep(),
                array('type' => $user->getType())
            )
        );
    }

    /**
     * @Route("/register/{type}/step2", name="register_step2")
     */
    public function registerStep2Action(Request $request, $type = 'user')
    {
        $manager = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if (!$this->get('security.context')->isGranted('ROLE_USER')) {
            return $this->redirect(
                $this->generateUrl("register")
            );
        }

        if ($type == 'user') {
            $form = $this->createForm(
                new UserStep2RegistrationFormType(),
                $user
            );

            $form->handleRequest($request);
            if ($form->isValid()) {

                $postData = $this->getRequest()->request->get('user');

                $manager->persist($form->getData());
                $manager->flush();

                $this->setFlash('success', 'User has been succesfully updated');

                return $this->redirect($this->generateUrl('homepage'));
            }
        }
        else {
            if ($user->getVendor()) {
                $vendor = $user->getVendor();
            }
            else {
                $vendor = new Vendor();
                $user->setVendor($vendor);
            }

            $form = $this->createForm(
                new VendorStep2RegistrationFormType(),
                $vendor
            );

            $form->handleRequest($request);
            if ($form->isValid()) {

                // echo '<pre>'; print_r($form->getData()); echo '</pre>';
                // exit();

                $manager->persist($form->getData());
                $manager->flush();

                return $this->redirect($this->generateUrl('vendor_register_step3'));
            }
        }

        return $this->container->get('templating')->renderResponse(
            'PinterestLikeUserBundle:Registration:register.step2.html.twig',
            array(
                'form' => $form->createView(),
                'type' => $type
            )
        );
    }

    /**
     * TODO: Move to Vendor Registration
     *
     * @Route("/register/vendor/step3", name="vendor_register_step3")
     * @Route("/vendor/upload-media", name="vendor_upload_media")
     */
    public function vendorRegisterStep3Action(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if (!$this->get('security.context')->isGranted('ROLE_USER')) {
            return $this->redirect(
                $this->generateUrl("homepage")
            );
        }
        $vendor = $user->getVendor();
        $formImages = $this->createForm(
            new VendorMediaFormType($manager),
            $vendor
        );

        $formImages->handleRequest($request);

        $loadFormAgain = false;

        // form images
        if ($formImages->isValid()) {

            $postData = $this->getRequest()->request->get('vendor_images');

            $vendor = $formImages->getData();

            $manager->persist($vendor);

            $loadFormAgain = $this->deleteCollections($manager, 'images', $postData['images'], $vendor);

            $manager->flush();

            $this->setFlash('success', 'Vendor Images has been succesfully updated');

            if ($loadFormAgain) {
                return $this->redirect($this->generateUrl('vendor_register_step3'));
            }

            // save or next buttons
            // return $this->redirect($this->generateUrl('homepage'));
        }

        $formVideos = $this->createForm(
            new VendorMediaFormType($manager, 'videos'),
            $vendor
        );

        $formVideos->handleRequest($request);

        $formType = 'images';
        $videoData = $this->getRequest()->request->get('vendor_videos');
        if (!empty($videoData)) {
            $formType = 'videos';
        }

        $loadFormAgain = false;

        // form images
        if ($formVideos->isValid()) {

            $postData = $this->getRequest()->request->get('vendor_videos');

            $vendor = $formVideos->getData();

            $manager->persist($vendor);

            $loadFormAgain = $this->deleteCollections($manager, 'videos', $postData['videos'], $vendor);

            $manager->flush();

            $this->setFlash('success', 'Vendor Videos has been succesfully updated');

            if ($loadFormAgain) {
                return $this->redirect($this->generateUrl('vendor_register_step3'));
            }

            // save or next buttons
            // return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->container->get('templating')->renderResponse(
            'PinterestLikeUserBundle:Registration:register.step3.vendor.html.twig',
            array(
                'vendor'     => $vendor,
                'formImages' => $formImages->createView(),
                'formVideos' => $formVideos->createView(),
                'formType'   => $formType
            )
        );
    }

    // TODO : refactor this method
    private function deleteCollections($manager, $type, $postData, $entity)
    {
        $removed = false;

        if ($type == 'images') {
            $imageRepository = $manager->getRepository('PinterestLikeVendorBundle:VendorImage');
            foreach ($postData as $image) {
                if (!empty($image['remove'])) {
                    $imageEntity = $imageRepository->find($image['remove']);
                    if ($imageEntity) {
                        $entity->removeImage($imageEntity);
                        $manager->remove($imageEntity);
                        $removed = true;
                    }
                }
            }
        }

        elseif ($type == 'videos') {
            $videoRepository = $manager->getRepository('PinterestLikeVendorBundle:VendorVideo');
            foreach ($postData as $video) {
                if (!empty($video['remove'])) {
                    $videoEntity = $videoRepository->find($video['remove']);
                    if ($videoEntity) {
                        $entity->removeVideo($videoEntity);
                        $manager->remove($videoEntity);
                        $removed = true;
                    }
                }
            }
        }

        return $removed;
    }

    /**
     * TODO: Move to a Service
     *
     * @Route("/register/vendor/add/video", name="vendor_add_video")
     */
    public function registerVendorAddVideo(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $url = $request->get('url');

        $vendor = $user = $this->container->get('security.token_storage')->getToken()->getUser()->getVendor();

        $youtubeVideoId = '';
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            $youtubeVideoId = $match[1];
        }
        elseif (preg_match("/(?:https?:\/\/)?(?:www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/", $url, $id)) {
            $vimeoVideoId = $id[3];
        }

        $vendorVideo = new VendorVideo();
        $vendorVideo->setVendor($vendor);
        $vendorVideo->setVideoUrl($url);
        $vendorVideo->setCreatedAt(new \DateTime());

        // check youtube
        if (!empty($youtubeVideoId)) {

            $vendorVideo->setVideoType('youtube');
            $vendorVideo->setVideoId($youtubeVideoId);

            $youtubeService = $this->container->get('happyr.google.api.youtube');

            $status = $youtubeService->getStatus($youtubeVideoId);
            $thumbnails = $youtubeService->getThumbnails($youtubeVideoId, 'high');
            $snippet = $youtubeService->getSnippet($youtubeVideoId);

            $vendorVideo->setName($snippet['title']);
            $vendorVideo->setDescription(strip_tags($snippet['description']));

            $paseUrl = parse_url($thumbnails['url']);
            $imageContent = file_get_contents($thumbnails['url']);

            // echo '<pre>'; print_r($imageContent); echo '</pre>';
            $tmpfname = tempnam("/tmp", $youtubeVideoId . '-' . basename($thumbnails['url']));
            $handle = fopen($tmpfname, "w");
            fwrite($handle, $imageContent);
            fclose($handle);

        }

        elseif (!empty($vimeoVideoId)) {

            $urlApi = 'https://vimeo.com/api/v2/video/' . $vimeoVideoId . '.json';

            $curl = curl_init($urlApi);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            $return = curl_exec($curl);
            curl_close($curl);

            if (!empty($return)) {

                $return = json_decode($return, true);
                $vendorVideo->setVideoType('vimeo');
                $vendorVideo->setVideoId($vimeoVideoId);

                $vendorVideo->setName($return[0]['title']);
                $vendorVideo->setDescription(strip_tags($return[0]['description']));

                $imageContent = file_get_contents($return[0]['thumbnail_large']);

                // echo '<pre>'; print_r($imageContent); echo '</pre>';
                $tmpfname = tempnam("/tmp", $youtubeVideoId . '-' . basename($return[0]['thumbnail_large']));
                $handle = fopen($tmpfname, "w");
                fwrite($handle, $imageContent);
                fclose($handle);
            }
        }

        $response = [];
        if (!empty($tmpfname)) {

            $file = new File($tmpfname, false);

            $vendorVideo->setFile($file);
            $vendorVideo->preUpload();
            $vendorVideo->upload();

            $manager->persist($vendorVideo);
            $manager->flush();

            $response['video']['id'] = $vendorVideo->getId();
            $response['video']['src'] = '/' . $vendorVideo->getWebPath();
            $response['video']['description'] = $vendorVideo->getDescription();
        }

        return new JsonResponse(array('result' => $response));
    }

}
