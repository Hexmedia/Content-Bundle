<?php

namespace Hexmedia\ContentBundle\Controller;

use Doctrine\ORM\EntityManager;
use Hexmedia\AdministratorBundle\Controller\ListTrait;
use Symfony\Component\HttpFoundation\Request;
use Hexmedia\AdministratorBundle\ControllerInterface\BreadcrumbsInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController as Controller;
use Hexmedia\AdministratorBundle\ControllerInterface\ListController as ListControllerInterface;
use Hexmedia\ContentBundle\Entity\Area;
use Hexmedia\ContentBundle\Form\Type\Area\AddType;
use Hexmedia\ContentBundle\Form\Type\Area\EditType;

/**
 * Area controller.
 */
class AreaController extends Controller implements ListControllerInterface, BreadcrumbsInterface
{
    use ListTrait;

    /**
     * Index
     *
     * @param int $page
     * @param int $pageSize
     * @param string $sort
     * @param string $sortDirection
     *
     * @Rest\View
     */
    public function indexAction($page = 1, $pageSize = 10, $sort = 'id', $sortDirection = "ASC")
    {

    }

    /**
     * Lists all Area entities.
     *
     * @Rest\View
     */
    public function listAction($page = 1, $pageSize = 10, $sort = 'id', $sortDirection = "ASC")
    {

        $entities = $this->getRepository()->getPage($page, $sort, $pageSize, $sortDirection);

        $entitesRet = $this->prepareEntities($entities);

        return array(
            'entities' => $entitesRet,
            "entitiesCount" => $this->getRepository()->getCount()
        );
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

    protected function getFieldsToDisplayOnList()
    {
        return [
            "number" => "number",
            "id" => "getId",
            "page" => "getPage",
            "name" => "getName",
            "route" => "getRoute",
            "lastModified" => ['get' => "getUpdatedAt", 'format' => 'timeformat']
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
            $this->get('translator')->trans("Area"),
            $this->get('router')->generate('HexMediaContentArea')
        );

        return $this->breadcrumbs;
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
            new AddType(),
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
            new EditType(),
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

    /**
     * Updating area from raptor.
     *
     * @Rest\View
     */
    public function raptorUpdateAction()
    {

    }
}
