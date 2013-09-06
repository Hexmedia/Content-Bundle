<?php

namespace Hexmedia\ContentBundle\Controller;

use Hexmedia\AdministratorBundle\ControllerInterface\BreadcrumbsInterface;
use Hexmedia\AdministratorBundle\ControllerInterface\ListController;
use Hexmedia\AdministratorBundle\ControllerInterface\WhiteOctober;
use Hexmedia\ContentBundle\Form\Type\PageTypeAdd;
use Hexmedia\ContentBundle\Form\Type\PageTypeEdit;
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

    /**
     * @va \WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs
     */
    private $breadcrumbs;

    /**
     * Lists all Page entities.
     *
     * @Rest\View
     */
    public function listAction($page = 1, $pageSize = 10, $sort = 'id', $sortDirection = "ASC")
    {
        $this->registerBreadcrubms();

        $entities = $this->getRepository()->getPage($page, $sort, $pageSize, $sortDirection);
        $agoHelper = $this->container->get('hexmedia.templating.helper.time_formatter');

        $i = 0;
        $entitesRet = [];

        foreach ($entities as $entity) {
            $r = new \stdClass();
            $r->id = $entity->getId();
            $r->number = ++$i;
            $r->title = $entity->getTitle();
            $r->slug = $entity->getSlug();
            $r->published = $entity->getPublished();
            $r->publishedFrom = $entity->getPublishedFrom() != null ? $agoHelper->formatTime(
                $entity->getPublishedFrom()
            ) : "not set";
            $r->publishedTo = $entity->getPublishedTo() != null ? $agoHelper->formatTime(
                $entity->getPublishedTo()
            ) : "not set";
            $r->lastModified = $entity->getUpdatedAt() == null ? $agoHelper->formatTime(
                $entity->getCreatedAt()
            ) : $agoHelper->formatTime($entity->getUpdatedAt());

            $entitesRet[] = (array)$r;
        }

        return [
            'entities' => $entitesRet,
            "entitiesCount" => $this->getRepository()->getCount()
        ];
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
     *
     * @return \Hexmedia\ContentBundle\Repository\Doctrine\PageRepository
     */
    private function getRepository()
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('HexmediaContentBundle:Page');
    }

    /**
     * Creates a new Page entity.
     *
     * @Rest\View(template="HexmediaContentBundle:Page:add.html.twig)
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

            return $this->redirect($this->generateUrl('page_show', array('id' => $entity->getId())));
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
            new PageTypeAdd(),
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
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HexmediaContentBundle:Page')->find($id);

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
            new PageTypeEdit(),
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
}
