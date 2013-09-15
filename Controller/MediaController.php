<?php

namespace Hexmedia\ContentBundle\Controller;

use Hexmedia\AdministratorBundle\Controller\ListTrait;
use Hexmedia\AdministratorBundle\ControllerInterface\BreadcrumbsInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController as Controller;
use Hexmedia\AdministratorBundle\ControllerInterface\ListController as ListControllerInterface;
use Hexmedia\ContentBundle\Form\Type\Media\AddType;
use Hexmedia\ContentBundle\Form\Type\Media\EditType;
use Hexmedia\ContentBundle\Entity\Media;
use Symfony\Component\HttpFoundation\Request;

class MediaController extends Controller implements ListControllerInterface, BreadcrumbsInterface
{
    use ListTrait;

    /**
     * @var \WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs
     */
    private $breadcrumbs;

    /**
     * {@inheritDoc}
     */
    public function registerBreadcrubms()
    {
        $this->breadcrumbs = $this->get("white_october_breadcrumbs");

        $this->breadcrumbs->addItem($this->get('translator')->trans("Content"));
        $this->breadcrumbs->addItem($this->get('translator')->trans("Media Library"), $this->get('router')->generate('HexMediaContentMediaLibrary'));

        return $this->breadcrumbs;
    }

    /**
     * Creates a new Media entity.
     *
     * @Rest\View(template="HexmediaContentBundle:Media:add.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Media();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);

            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Media has been added!');

            if ($form->get("saveAndExit")->isClicked()) {
                return $this->redirect($this->generateUrl('HexMediaContentMediaLibrary'));
            } else {
                return $this->redirect($this->generateUrl('HexMediaContentMediaEdit', array('id' => $entity->getId())));
            }
        }

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Creates a form to create a Media entity.
     *
     * @param Media $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Media $entity)
    {
        $form = $this->createForm(
            new AddType(),
            $entity,
            [
                'action' => $this->generateUrl('HexMediaContentMediaCreate'),
                'method' => 'POST',
            ]
        );

        return $form;
    }

    /**
     * @Rest\View
     */
    public function addAction()
    {
        $breadcrumbs = $this->registerBreadcrubms();
        $breadcrumbs->addItem("Add");

        $entity = new Media();

        $form = $this->createCreateForm($entity);

        return [
            'form' => $form->createView(),
            'entity' => $entity
        ];
    }

    /**
     * @param $id
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @Rest\View
     */
    public function editAction($id) {
        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Media entity.');
        }

        $form = $this->createEditForm($entity);

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }
    /**
     * Creates a form to edit a Media entity.
     *
     * @param Media $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Media $entity)
    {
        $form = $this->createForm(
            new EditType(),
            $entity,
            [
                'action' => $this->generateUrl('HexMediaContentMediaUpdate', array('id' => $entity->getId())),
                'method' => 'PUT',
            ]
        );

        return $form;
    }

    /**
     * @param Request $request
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @Rest\View(template="HexmediaContentBundle:Media:edit")
     */
    public function updateAction(Request $request, $id)
    {
        $breadcrumbs = $this->registerBreadcrubms();
        $breadcrumbs->addItem("Edit");

        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Media entity.');
        }

        $em = $this->getDoctrine()->getManager();

        $form = $this->createEditForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($em->getUnitOfWork()->isScheduledForUpdate($entity)) {
                $this->get('session')->getFlashBag()->add('notice', 'Media has been updated!');
            }

            $em->flush();

            if ($form->get("saveAndExit")->isClicked()) {
                return $this->redirect($this->generateUrl('HexMediaContentMediaLibrary'));
            } else {
                return $this->redirect($this->generateUrl('HexMediaContentMediaEdit', ['id' => $entity->getId()]));
            }
        }

        return [
            'entity' => $entity,
            'form' => $form->createView()
        ];
    }

    /**
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     *
     * @Rest\View
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('HexmediaContentBundle:Media');

        $media = $repository->findOneById($id);

        if (!$media instanceof Media) {
            throw new NotFoundHttpException('Media not found');
        }

        $em->remove($media);
        $em->flush();

        return ['success' => true];
    }

    /**
     * @return array
     */
    public function customizeAction()
    {
        return [];
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @param string $sort
     * @param string $sortDirection
     * @return array
     *
     * @Rest\View
     */
    public function indexAction($page = 1, $pageSize = 10, $sort = 'id', $sortDirection = "ASC")
    {
        $this->registerBreadcrubms();

        return [];
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @param string $sort
     * @param string $sortDirection
     * @return array
     *
     * @Rest\View
     */
    public function listAction($page = 1, $pageSize = 10, $sort = 'id', $sortDirection = "ASC")
    {
        $entities = $this->getRepository()->getPage($page, $sort, $pageSize, $sortDirection);

        $entitiesRet = $this->prepareEntities($entities);

        return [
            'entities' => $entitiesRet,
            'entitiesCount' => $this->getRepository()->getCount()
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getFieldsToDisplayOnList()
    {
        return [
            "number" => "number",
            "id" => "getId",
            "name" => "getName",
            "lastModified" => ['get' => "getUpdatedAt", 'format' => 'timeformat'],
            "miniature" => ['get' => 'self', 'call' => function ($entity) {
                $cacheManager = $this->container->get('liip_imagine.cache.manager');
                $vichHelper = $this->container->get('vich_uploader.templating.helper.uploader_helper');

                return "<img src=\"" . $cacheManager->getBrowserPath($vichHelper->asset($entity, 'file'), 'small_admin_square') . "\" />";
            }],
            'image' => ['get' => 'self', 'call' => function ($entity) {
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
    private function getRepository()
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var \Hexmedia\ContentBundle\Repository\Doctrine\MediaRepository
         */
        $repository = $em->getRepository('HexmediaContentBundle:Media');

        return $repository;
    }

}
