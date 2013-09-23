<?php

namespace Hexmedia\ContentBundle\Controller;

use Hexmedia\AdministratorBundle\Controller\CrudController;
use Hexmedia\AdministratorBundle\Controller\ListTrait;
use FOS\RestBundle\Controller\Annotations as Rest;
use Hexmedia\ContentBundle\Form\Type\Media\AddType;
use Hexmedia\ContentBundle\Form\Type\Media\EditType;
use Hexmedia\ContentBundle\Entity\Media;
use Symfony\Component\HttpFoundation\Request;

class AdminMediaController extends CrudController
{
    /**
     * {@inheritDoc}
     */
    public function registerBreadcrubms()
    {
        $this->breadcrumbs = $this->get("white_october_breadcrumbs");

        $this->breadcrumbs->addItem($this->get('translator')->trans("Content"));
        $this->breadcrumbs->addItem($this->get('translator')->trans("Media Library"), $this->get('router')->generate('HexMediaContentMedia'));

        return $this->breadcrumbs;
    }

    /**
     * Creates a new Media entity.
     *
     * @Rest\View(template="HexmediaContentBundle:AdminMedia:add.html.twig")
     */
    public function createAction(Request $request)
    {
        return parent::createAction($request);
    }

    /**
     * @param Request $request
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @Rest\View(template="HexmediaContentBundle:AdminMedia:edit")
     */
    public function updateAction(Request $request, $id)
    {
        return parent::createAction($request, $id);
    }


    /**
     * @return array
     */
    public function customizeAction()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldsToDisplayOnList()
    {
        return [
            "number" => ['get' => "number", 'label' => '#', 'sortable' => false],
            "id" => ['get' => "getId", 'show' => false],
            "name" => ['get' => "getName", 'label' => 'Name'],
            "lastModified" => ['get' => "getUpdatedAt", 'format' => 'timeformat', 'label' => 'Last Modified'],
            "miniature" => ['get' => 'self', 'label' => 'Miniature', 'call' => function ($entity) {
                $cacheManager = $this->container->get('liip_imagine.cache.manager');
                $vichHelper = $this->container->get('vich_uploader.templating.helper.uploader_helper');

                return "<img src=\"" . $cacheManager->getBrowserPath($vichHelper->asset($entity, 'file'), 'small_admin_square') . "\" />";
            }],
            'image' => ['get' => 'self', 'label' => 'Image', 'call' => function ($entity) {
                $cacheManager = $this->container->get('liip_imagine.cache.manager');
                $vichHelper = $this->container->get('vich_uploader.templating.helper.uploader_helper');

                return "<img src=\"" . $cacheManager->getBrowserPath($vichHelper->asset($entity, 'file'), 'attach_admin_square') . "\" />";
            }]
        ];
    }

    /**
     * Attaching media
     *
     * @param string $type
     * @param int $page
     * @param int $pageSize
     * @param string $sort
     * @param string $sortDirection
     *
     * @return array
     *
     * @Rest\View
     */
    public function attachAction($type, $page = 1, $pageSize = 10, $sort = 'id', $sortDirection = "ASC")
    {
        $entities = $this->getRepository()->getPage($page, $sort, $pageSize, $sortDirection);
        $entitiesCount = $this->getRepository()->getCount();

        return [
            'entities' => $this->prepareEntities($entities),
            'entitiesCount' => $entitiesCount
        ];
    }

    /**
     * @return \Hexmedia\ContentBundle\Repository\Doctrine\MediaRepository
     */
    protected function getRepository()
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var \Hexmedia\ContentBundle\Repository\Doctrine\MediaRepository
         */
        $repository = $em->getRepository('HexmediaContentBundle:Media');

        return $repository;
    }

    protected function getNewEntity()
    {
        return new Media();
    }

    public function getMainRoute()
    {
        return "HexMediaContentMedia";
    }

    protected function getAddFormType()
    {
        return new AddType();
    }

    public function getEntityName()
    {
        return "Media";
    }

    protected function getEditFormType()
    {
        return new EditType();
    }
}