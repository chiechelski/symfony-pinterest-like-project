<?php

namespace PinterestLike\CoreBundle\Twig;


class SiteDataHelperExtension extends \Twig_Extension
{
    protected $memo;

    protected $container;

    /**
     * Constructor method
     *
     * @param IdentityTranslator $translator
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('get_site_data', array($this, 'getSiteData')),
        );
    }

    /**
     * @return mixed
     */
    function getSiteData()
    {
        if ($this->memo) { return $this->memo; }

        $result = array();

        return $this->memo = $result;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'site_data_helper';
    }
}
