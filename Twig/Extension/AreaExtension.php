<?php

namespace Hexmedia\ContentBundle\Twig\Extension;

use Doctrine\ORM\EntityManager;
use Hexmedia\ContentBundle\Twig\TokenParser\AreaTokenParser;
use Symfony\Component\HttpFoundation\Session\Session;

class AreaExtension extends \Twig_Extension
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    private $session;

    public function __construct(EntityManager $entityManager, Session $session)
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenParsers()
    {
        return [
            new AreaTokenParser()
        ];
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return "content_area_extension";
    }

    /**
     * @param string $name
     * #param string $defaultContent
     * @param bool   $isGlobal
     * @param string $locale
     */
    public function get($name, $defaultContent = "", $isGlobal = false, $locale = null)
    {
        return $defaultContent;
    }
}