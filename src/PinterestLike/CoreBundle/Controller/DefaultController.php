<?php

namespace PinterestLike\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PinterestLike\CoreBundle\Form\Type\ContactFormType;

use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PinterestLikeCoreBundle:Default:index.html.twig', array('name' => $name));
    }
}
