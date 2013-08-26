<?php

namespace Hexmedia\ContentBundle\Controller;

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
	 * {@inheritDoc}
	 */
	public function registerBreadcrubms()
	{
		$this->breadcrumbs = $this->get("white_october_breadcrumbs");

		$this->breadcrumbs->addItem($this->get('translator')->trans("Content"));
		$this->breadcrumbs->addItem($this->get('translator')->trans("Area"), $this->get('router')->generate('HexMediaContentArea'));

		return $this->breadcrumbs;
	}

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
			$r->lastModified = $entity->getUpdatedAt() == null ? $agoHelper->formatTime($entity->getCreatedAt()) : $agoHelper->formatTime($entity->getUpdatedAt());

			$entitesRet[] = $r;
		}
//
//		var_dump([
//			'entities' => $entitesRet,
//			"entitiesCount" => $this->getRepository()->getCount()
//		]);
//		die();


		return array(
			'entities' => $entitesRet,
			"entitiesCount" => $this->getRepository()->getCount()
		);
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

			return $this->redirect($this->generateUrl('HexMediaContentArea'));
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
		$form = $this->createForm(new AreaAddType(), $entity, array(
			'action' => $this->generateUrl('HexMediaContentAreaAdd'),
			'method' => 'POST',
		));

		$form->add('submit', 'submit', array('label' => 'Create'));

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
		$deleteForm = $this->createDeleteForm($id);

		return array(
			'entity' => $entity,
			'edit_form' => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
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
		$form = $this->createForm(new AreaEditType(), $entity, array(
			'action' => $this->generateUrl('area_update', array('id' => $entity->getId())),
			'method' => 'PUT',
		));

		$form->add('submit', 'submit', array('label' => 'Update'));

		return $form;
	}

	/**
	 * Edits an existing Area entity.
	 *
	 * @Rest\View("HexmediaContentBundle::Area/add")
	 */
	public function updateAction(Request $request, $id)
	{
		$entity = $this->getRepository()->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Area entity.');
		}

		$deleteForm = $this->createDeleteForm($id);
		$editForm = $this->createEditForm($entity);
		$editForm->handleRequest($request);

		if ($editForm->isValid()) {
			$em->flush();

			return $this->redirect($this->generateUrl('HexMediaContentArea', array('id' => $id)));
		}

		return array(
			'entity' => $entity,
			'edit_form' => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		);
	}

	/**
	 * Deletes a Area entity.
	 */
	public function deleteAction(Request $request, $id)
	{
		$form = $this->createDeleteForm($id);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$entity = $this->getRepository()->find($id);

			if (!$entity) {
				throw $this->createNotFoundException('Unable to find Area entity.');
			}

			$em->remove($entity);
			$em->flush();
		}

		return $this->redirect($this->generateUrl('HexMediaContentArea'));
	}

	/**
	 * Creates a form to delete a Area entity by id.
	 *
	 * @param mixed $id The entity id
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm($id)
	{
		return $this->createFormBuilder()
						->setAction($this->generateUrl('area_delete', array('id' => $id)))
						->setMethod('DELETE')
						->add('submit', 'submit', array('label' => 'Delete'))
						->getForm()
		;
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

}
