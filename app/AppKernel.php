<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Pinano\Bootstrap3Bundle\PinanoBootstrap3Bundle(),

            new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),
            new Oneup\UploaderBundle\OneupUploaderBundle(),

            new PinterestLike\CoreBundle\PinterestLikeCoreBundle(),
            new PinterestLike\StaticBundle\PinterestLikeStaticBundle(),
            new PinterestLike\UserBundle\PinterestLikeUserBundle(),

            new PinterestLike\VendorBundle\PinterestLikeVendorBundle(),

            // The admin requires some twig functions defined in the security
            // bundle, like is_granted
            // new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),

            // Add your dependencies
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),

            new Liip\ImagineBundle\LiipImagineBundle(),
            //...

            new HappyR\Google\ApiBundle\HappyRGoogleApiBundle(),

            // sonata
            // new Sonata\MediaBundle\SonataMediaBundle(),
            // new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            // new Sonata\IntlBundle\SonataIntlBundle(),
            //You need to add this dependency to make media functional
            // new JMS\SerializerBundle\JMSSerializerBundle(),

            // Then add SonataAdminBundle
            new Sonata\AdminBundle\SonataAdminBundle(),

            new FOS\UserBundle\FOSUserBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
