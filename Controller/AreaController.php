<?php

namespace Hexmedia\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Hexmedia\AdministratorBundle\ControllerInterface\BreadcrumbsInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController as Controller;
use Hexmedia\AdministratorBundle\ControllerInterface\ListController as ListControllerInterface;
use Hexmedia\ContentBundle\Entity\Area;
use Hexmedia\ContentBundle\Form\Type\AreaType;

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
		$em = $this->getDoctrine()->getManager();

		$entities = $em->getRepository('HexmediaContentBundle:Area')->findAll();

		return array(
			'entities' => $entities,
		);
	}

	/**
	 * Creates a new Area entity.
	 *
	 * @Rest\View
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

			return $this->redirect($this->generateUrl('area_show', array('id' => $entity->getId())));
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
		$form = $this->createForm(new AreaType(), $entity, array(
			'action' => $this->generateUrl('area_create'),
			'method' => 'POST',
		));

		$form->add('submit', 'submit', array('label' => 'Create'));

		return $form;
	}

	/**
	 * Displays a form to create a new Area entity.
	 *
	 * @Rest\Method("GET")
	 * @Rest\View
	 */
	public function newAction()
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
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('HexmediaContentBundle:Area')->find($id);

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
		$form = $this->createForm(new AreaType(), $entity, array(
			'action' => $this->generateUrl('area_update', array('id' => $entity->getId())),
			'method' => 'PUT',
		));

		$form->add('submit', 'submit', array('label' => 'Update'));

		return $form;
	}

	/**
	 * Edits an existing Area entity.
	 *
	 * @Rest\View
	 */
	public function updateAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('HexmediaContentBundle:Area')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Area entity.');
		}

		$deleteForm = $this->createDeleteForm($id);
		$editForm = $this->createEditForm($entity);
		$editForm->handleRequest($request);

		if ($editForm->isValid()) {
			$em->flush();

			return $this->redirect($this->generateUrl('area_edit', array('id' => $id)));
		}

		return array(
			'entity' => $entity,
			'edit_form' => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		);
	}

	/**
	 * Deletes a Area entity.
	 *
	 * @Rest\View
	 */
	public function deleteAction(Request $request, $id)
	{
		$form = $this->createDeleteForm($id);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$entity = $em->getRepository('HexmediaContentBundle:Area')->find($id);

			if (!$entity) {
				throw $this->createNotFoundException('Unable to find Area entity.');
			}

			$em->remove($entity);
			$em->flush();
		}

		return $this->redirect($this->generateUrl('area'));
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

}
