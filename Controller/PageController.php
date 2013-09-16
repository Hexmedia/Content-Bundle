<?php

namespace Hexmedia\ContentBundle\Controller;

use Hexmedia\AdministratorBundle\Controller\ListTrait;
use Hexmedia\AdministratorBundle\ControllerInterface\BreadcrumbsInterface;
use Hexmedia\AdministratorBundle\ControllerInterface\ListController;
use Hexmedia\AdministratorBundle\ControllerInterface\WhiteOctober;
use Hexmedia\ContentBundle\Form\Type\Page\AddType;
use Hexmedia\ContentBundle\Form\Type\Page\EditType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController as Controller;

use Hexmedia\ContentBundle\Entity\Page;
use Hexmedia\ContentBundle\Form\PageType;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Page controller.
 *
 */
class PageController extends Controller implements ListController, BreadcrumbsInterface
{
    use ListTrait;

    /**
     * @var \WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs
     */
    private $breadcrumbs;

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
     * {@inheritDoc}
     */
    public function registerBreadcrubms()
    {
        $this->breadcrumbs = $this->get("white_october_breadcrumbs");

        $this->breadcrumbs->addItem($this->get('translator')->trans("Content"));
        $this->breadcrumbs->addItem(
            $this->get('translator')->trans("Page"),
            $this->get('router')->generate('HexMediaContentPage')
        );

        return $this->breadcrumbs;
    }

    /**
     * Lists all Page entities.
     *
     * @param int $page
     * @param int $pageSize
     * @param string $sort
     * @param string $sortDirection
     *
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
            "entitiesCount" => $this->getRepository()->getCount()
        ];
    }

    /**
     *
     * @return \Hexmedia\ContentBundle\Repository\Doctrine\PageRepository
     */
    private function getRepository()
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('HexmediaContentBundle:Page');
    }

    protected function getFieldsToDisplayOnList()
    {
        return [
            'id' => 'getId',
            'number' => 'number',
            'title' => 'getTitle',
            'slug' => 'getSlug',
            'published' => ['get' => 'getPublished', 'format' => 'bool'],
            'publishedFrom' => ['get' => 'getPublishedFrom', 'format' => 'timeformat'],
            'publishedTo' => ['get' => 'getPublishedTo', 'format' => 'timeformat'],
            'lastModified' => ['get' => 'getUpdatedAt', 'format' => 'timeformat']
        ];
    }

    /**
     * Creates a new Page entity.
     *
     * @Rest\View(template="HexmediaContentBundle:Page:add.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Page();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);

            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Page has been added!');

            if ($form->get("saveAndExit")->isClicked()) {
                return $this->redirect($this->generateUrl('HexMediaContentPage'));
            } else {
                return $this->redirect($this->generateUrl('HexMediaContentPageEdit', array('id' => $entity->getId())));
            }
        }

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Creates a form to create a Page entity.
     *
     * @param Page $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Page $entity)
    {
        $form = $this->createForm(
            new AddType(),
            $entity,
            [
                'action' => $this->generateUrl('HexMediaContentPageCreate'),
                'method' => 'POST',
            ]
        );

        return $form;
    }

    /**
     * Displays a form to create a new Page entity.
     *
     * @Rest\View
     */
    public function addAction()
    {
        $entity = new Page();
        $form = $this->createCreateForm($entity);

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Finds and displays a Page entity.
     *
     * @Rest\View()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HexmediaContentBundle:Page')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return [
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing Page entity.
     *
     * @Rest\View()
     */
    public function editAction($id)
    {
        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $form = $this->createEditForm($entity);

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Creates a form to edit a Page entity.
     *
     * @param Page $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Page $entity)
    {
        $form = $this->createForm(
            new EditType(),
            $entity,
            [
                'action' => $this->generateUrl('HexMediaContentPageUpdate', array('id' => $entity->getId())),
                'method' => 'PUT',
            ]
        );

        return $form;
    }

    /**
     * Edits an existing Page entity.
     *
     * @Rest\View(template="HexmediaContentBundle:Page:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HexmediaContentBundle:Page')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $form = $this->createEditForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($em->getUnitOfWork()->isScheduledForUpdate($entity)) {
                $this->get('session')->getFlashBag()->add('notice', 'Page has been updated!');
            }

            $em->flush();

            if ($form->get("saveAndExit")->isClicked()) {
                return $this->redirect($this->generateUrl('HexMediaContentPage'));
            } else {
                return $this->redirect($this->generateUrl('HexMediaContentPageEdit', ['id' => $entity->getId()]));
            }
        }

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Deletes a Page entity.
     *
     * @Rest\View
     */
    public function deleteAction(Request $request, $id)
    {
        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }
        $em = $this->getDoctrine()->getManager();

        $em->remove($entity);

        $em->flush();

        return array('success' => true);
    }

    /**
     * @param string $ident
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function displayAction($ident, $template = "HexmediaContentBundle:Page:display.html.twig") {
        /**
         * @var $entity \Hexmedia\ContentBundle\Entity\Slider
         */
        $entity = $this->getRepository()->findOneBySlug($ident);

        return $this->render($template, [
                'page' => $entity
            ]);
    }
}
