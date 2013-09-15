<?php

namespace Hexmedia\ContentBundle\Twig\Extension;

use Doctrine\ORM\EntityManager;
use Hexmedia\ContentBundle\Entity\Area;
use Hexmedia\ContentBundle\Repository\AreaRepositoryInterface;
use Hexmedia\ContentBundle\Twig\TokenParser\AreaTokenParser;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Translation\Translator;

class AreaExtension extends \Twig_Extension
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
     * @param string $type
     * @param string $class
     * @param string $defaultContent
     * @param bool $isGlobal
     * @param string $locale
     * @return string
     */
    public function get($name, $type, $class, $defaultContent = "", $isGlobal = false, $locale = null)
    {
        /**
         * @var AreaRepositoryInterface
         */
        $repo = $this->entityManager->getRepository("HexmediaContentBundle:Area");

        /**
         * @var \Symfony\Component\HttpFoundation\Request
         */
        $request = $this->service->get('request');

        if ($locale === null) {
            $locale = $request->getLocale();
        }

        $requestUri = $request->getRequestUri();

        $requestUri = substr(
            $requestUri,
            strpos($requestUri, $request->getBasePath()) + strlen($request->getBasePath())
        );

        if (strpos($requestUri, "?") !== false) {
            $requestUri = substr($requestUri, 0, strpos($requestUri, "?"));
        }

        $route = $request->get('_route');

        $routePath = md5($requestUri . $route . $locale);

        if ($isGlobal) {
            $entity = $repo->getGlobalByName($name);
        } else {
            $entity = $repo->getByNameAndPath($name, $routePath);
        }


        if ($requestUri{strlen($requestUri)-1} == "/") {
            $requestUri = substr($requestUri, 0, strlen($requestUri) - 1);
        }

        if ($entity === null) {
            //Create entity and write it to database
            $entity = new Area();

            $entity->setLocale($locale);
            $entity->setName($name);
            $entity->setContent($defaultContent);
            $entity->setGlobal($isGlobal);
            $entity->setPath($routePath);
            $entity->setPage($requestUri);
            $entity->setRoute($route);

            $this->entityManager->persist($entity);

            $this->entityManager->flush();
        }

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