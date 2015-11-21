<?php

namespace PinterestLike\StaticBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $manager = $this->getDoctrine()->getManager();

        $imageRepository = $manager->getRepository('PinterestLikeVendorBundle:VendorImage');

        $request = $this->getRequest();
        $params['search-term'] = $request->get('search-term', '');

        $allMedia = $imageRepository->getAllMedia(0, 0, $params);

        return $this->render('PinterestLikeStaticBundle:Default:index.html.twig',
            array(
                'searchTerm' => $params['search-term'],
                'allMedia' => $allMedia
            )
        );
    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutAction()
    {
        return $this->render('PinterestLikeStaticBundle:Default:about.html.twig', array());
    }

    /**
     * TODO - Change to slug
     *
     * @Route("/category/{id}", name="filter_category")
     */
    public function categoryAction(\PinterestLike\VendorBundle\Entity\Category $category)
    {
        $manager = $this->getDoctrine()->getManager();

        $imageRepository = $manager->getRepository('PinterestLikeVendorBundle:VendorImage');

        $params = array('category' => $category->getId());

        $allMedia = $imageRepository->getAllMedia(0, 0, $params);

        return $this->render('PinterestLikeStaticBundle:Default:category.html.twig',
            array(
                'pageCategory' => $category,
                'allMedia' => $allMedia
            )
        );
    }

    /**
     * TODO - Change to slug
     *
     * @Route("/colour/{id}", name="filter_colour")
     */
    public function colourAction(\PinterestLike\VendorBundle\Entity\Colour $colour)
    {
        $manager = $this->getDoctrine()->getManager();

        $imageRepository = $manager->getRepository('PinterestLikeVendorBundle:VendorImage');

        $params = array('colour' => $colour->getId());

        $allMedia = $imageRepository->getAllMedia(0, 0, $params);

        return $this->render('PinterestLikeStaticBundle:Default:colour.html.twig',
            array(
                'pageColour' => $colour,
                'allMedia' => $allMedia
            )
        );
    }

    /**
     * @Route("/terms", name="terms")
     */
    public function termsAction()
    {
        return $this->render('PinterestLikeStaticBundle:Default:terms.html.twig', array());
    }
}
