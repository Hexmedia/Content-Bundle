<?php

namespace Hexmedia\ContentBundle\Twig\Extension;

use Doctrine\ORM\EntityManager;
use Hexmedia\ContentBundle\Entity\Page;
use Hexmedia\ContentBundle\Repository\AreaRepositoryInterface;
use Hexmedia\ContentBundle\Twig\TokenParser\PageTokenParser;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Translation\Translator;

class PageExtension extends \Twig_Extension
{
    /**
     * @var EntityManager
     */
    private $entityManager;
    private $service;

    public function __construct(EntityManager $entityManager, $service)
    {
        $this->entityManager = $entityManager;
        $this->service = $service;
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenParsers()
    {
        return [
            new PageTokenParser()
        ];
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return "content_page_extension";
    }

    /**
     * @param \Hexmedia\ContentBundle\Entity\Page $entity
     * @param string $field
     * @param string $class
     * @throws Exception
     * @internal param \Hexmedia\ContentBundle\Entity\Page $page
     * @internal param string $name #param string $defaultContent* #param string $defaultContent
     * @internal param string $type
     * @internal param string $defaultContent
     * @internal param bool $isGlobal
     * @internal param string $locale
     * @return string
     */
    public function get(Page $entity, $field = "content",  $class = null)
    {
        /**
         * @var \Symfony\Component\HttpFoundation\Request
         */
        $request = $this->service->get('request');

        $slug = $request->get('ident');

        $locale = $request->getLocale();

        if (!$entity) {
            throw new Exception("Page does not exists.");
        }

        $getter = "get" . strtoupper($field);

        return $entity->$getter();

        $twig = $this->service->get("twig");

        if ($twig instanceof \Twig_Environment) {
            ;
        }

        if ($this->service->get('session')->get('hexmedia_content_edit_mode')) {
            $content = $twig->render(
                "HexmediaContentBundle:Area:area-editable.html.twig",
                [
                    'content' => $entity->getContent(),
                    'path' => $entity->getPath(),
                    'type' => $type,
                    'class' => $class
                ]
            );
        } else {
            $content = $twig->render(
                "HexmediaContentBundle:Area:area.html.twig",
                [
                    'content' => $entity->getContent(),
                    'path' => $entity->getPath(),
                    'type' => $type,
                    'class' => $class
                ]
            );
        }

        return $content; //$entity->getContent();
    }
}