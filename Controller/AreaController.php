<?php

namespace Hexmedia\ContentBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Hexmedia\AdministratorBundle\ControllerInterface\BreadcrumbsInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController as Controller;
use Hexmedia\AdministratorBundle\ControllerInterface\ListController as ListControllerInterface;
use Hexmedia\ContentBundle\Entity\Area;
use Hexmedia\ContentBundle\Form\Type\AreaAddType;
use Hexmedia\ContentBundle\Form\Type\AreaEditType;

/**
 * Area controller.
 */
class AreaController extends Controller implements ListControllerInterface, BreadcrumbsInterface
{

    /**
     * Lists all Area entities.
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
            $r->name = $entity->getName();
            $r->slug = $entity->getSlug();
            $r->lastModified = $entity->getUpdatedAt() == null ? $agoHelper->formatTime(
                $entity->getCreatedAt()
            ) : $agoHelper->formatTime($entity->getUpdatedAt());

            $entitesRet[] = (array)$r;
        }

        return array(
            'entities' => $entitesRet,
            "entitiesCount" => $this->getRepository()->getCount()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function registerBreadcrubms()
    {
        $this->breadcrumbs = $this->get("white_october_breadcrumbs");

        $this->breadcrumbs->addItem($this->get('translator')->trans("Content"));
        $this->breadcrumbs->addItem(
            $this->get('translator')->trans("Area"),
            $this->get('router')->generate('HexMediaContentArea')
        );

        return $this->breadcrumbs;
    }

    /**
     *
     * @return \Hexmedia\ContentBundle\Repository\Doctrine\AreaRepository
     */
    private function getRepository()
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('HexmediaContentBundle:Area');
    }

    /**
     * Creates a new Area entity.
     *
     * @Rest\View(template="HexmediaContentBundle:Area:add.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Area();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Area has been created!');

            if ($form->get("saveAndExit")->isClicked()) {
                return $this->redirect($this->generateUrl('HexMediaContentArea'));
            } else {
                return $this->redirect($this->generateUrl('HexMediaContentAreaEdit', ['id' => $entity->getId()]));
            }
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Area entity.
     *
     * @param Area $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Area $entity)
    {
        $form = $this->createForm(
            new AreaAddType(),
            $entity,
            array(
                'action' => $this->generateUrl('HexMediaContentAreaAdd'),
                'method' => 'POST',
            )
        );

        return $form;
    }

    /**
     * Displays a form to create a new Area entity.
     *
     * @Rest\View
     */
    public function addAction()
    {
        $entity = new Area();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Area entity.
     *
     * @Rest\View
     */
    public function editAction($id)
    {
        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Area entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity' => $entity,
            'form' => $editForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Area entity.
     *
     * @param Area $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Area $entity)
    {
        $form = $this->createForm(
            new AreaEditType(),
            $entity,
            array(
                'action' => $this->generateUrl('HexMediaContentAreaUpdate', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        return $form;
    }

    /**
     * Edits an existing Area entity.
     *
     * @Rest\View(template="HexmediaContentBundle:Area:add.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        /**
         * @var $entity Area
         */
        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Area entity.');
        }

        $form = $this->createEditForm($entity);
        $form->handleRequest($request);

        if ($form->get("exit")->isClicked()) {
            return $this->redirect($this->generateUrl('HexMediaContentArea'));
        } else {
            if ($form->isValid()) {
                /**
                 * @var $em \Doctrine\ORM\EntityManager
                 */
                $em = $this->getDoctrine()->getManager();

                if ($em->getUnitOfWork()->isScheduledForUpdate($entity)) {
                    $this->get('session')->getFlashBag()->add('notice', 'Area has been updated!');
                }

                $em->flush();

                if ($form->get("saveAndExit")->isClicked()) {
                    return $this->redirect($this->generateUrl('HexMediaContentArea'));
                } else {
                    return $this->redirect($this->generateUrl('HexMediaContentAreaEdit', array('id' => $id)));
                }
            }
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Deletes a Area entity.
     *
     * @Rest\View()
     */
    public function deleteAction(Request $request, $id)
    {
        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Area entity.');
        }
        $em = $this->getDoctrine()->getManager();

        $em->remove($entity);

        $em->flush();

        return array('success' => true);
    }

}
