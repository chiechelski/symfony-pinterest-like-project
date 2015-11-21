<?php

namespace PinterestLike\VendorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PinterestLike\VendorBundle\Entity\Vendor;
use PinterestLike\VendorBundle\Entity\VendorQuestion;
use PinterestLike\UserBundle\Form\Type\VendorStep2RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PinterestLikeVendorBundle:Default:index.html.twig', array('name' => $name));
    }

    /**
     * @Route("/vendor/media/moreinfo/{type}/{id}", name="vendor_media_moreinfo")
     */
    public function moreInfoAction($type, $id)
    {
        $manager = $this->getDoctrine()->getManager();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ($type == 'image') {
            $imageRepository = $manager->getRepository('PinterestLikeVendorBundle:VendorImage');
            $entity = $imageRepository->find($id);
        }
        else {
            $videoRepository = $manager->getRepository('PinterestLikeVendorBundle:VendorVideo');
            $entity = $videoRepository->find($id);
        }

        $vendor = $entity->getVendor();

        return $this->render('PinterestLikeVendorBundle:Default:media.moreinfo.html.twig',
                array(
                    'type' => $type,
                    'entity' => $entity,
                    'vendor' => $vendor
                )
            );
    }

    /**
     * TODO: Change ID to slug
     *
     * @Route("/vendor/{vendor}/question", name="vendor_question")
     */
    public function vendorQuestionAction(Request $request, Vendor $vendor)
    {
        $manager = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $vendorQuestion = new VendorQuestion();

        if (empty($vendorQuestion)) {
            return JsonResponse(
                array(
                    'result' => 0,
                    'error' => 'Empty message'
                )
            );
        }
        else if (!$this->get('security.context')->isGranted('ROLE_USER')) {
            return JsonResponse(
                array(
                    'result' => 0,
                    'error' => 'You must login first'
                )
            );
        }

        $vendorQuestion->setUser($user);
        $vendorQuestion->setVendor($vendor);

        $message = $request->get('question');
        $vendorQuestion->setMessage($message);

        $vendorQuestion->setCreatedAt(new \DateTime());

        $manager->persist($vendorQuestion);
        $manager->flush();

        $response = [];
        $response['vendor-question']['id'] = $vendorQuestion->getId();

        return new JsonResponse(
            array(
                'result' => $response
            )
        );
    }

    /**
     * TODO: Change ID to slug
     *
     * @Route("/vendor/{vendor}/profile", name="vendor_profile")
     */
    public function vendorProfileAction(Vendor $vendor)
    {
        $manager = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $imageRepository = $manager->getRepository('PinterestLikeVendorBundle:VendorImage');
        $allMedia = $imageRepository->getAllMedia($vendor->getId());

        return $this->container->get('templating')->renderResponse(
            'PinterestLikeVendorBundle:Default:vendor.profile.html.twig',
            array(
                'vendor'   => $vendor,
                'allMedia' => $allMedia
            )
        );
    }

    /**
     * Vendor Settings
     *
     * @Route("/vendor/settings", name="vendor_settings")
     */
    public function vendorSettingsAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $vendor = $user->getVendor();

        $form = $this->createForm(
            new VendorStep2RegistrationFormType(),
            $vendor
        );

        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager->persist($form->getData());
            $manager->flush();
        }

        return $this->container->get('templating')->renderResponse(
            'PinterestLikeVendorBundle:Default:vendor.settings.html.twig',
            array(
                'form' => $form->createView(),
                'vendor'   => $vendor
            )
        );
    }

    /**
     * Vendor Dashboard
     *
     * @Route("/vendor/dashboard", name="vendor_dashboard")
     */
    public function vendorDashboardAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $vendor = $user->getVendor();

        $form = $this->createForm(
            new VendorStep2RegistrationFormType(),
            $vendor
        );

        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager->persist($form->getData());
            $manager->flush();
        }

        return $this->container->get('templating')->renderResponse(
            'PinterestLikeVendorBundle:Default:vendor.dashboard.html.twig',
            array(
                'form' => $form->createView(),
                'vendor'   => $vendor
            )
        );
    }
}
