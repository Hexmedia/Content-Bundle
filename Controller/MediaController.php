<?php

namespace Hexmedia\ContentBundle\Controller;

use Hexmedia\AdministratorBundle\ControllerInterface\BreadcrumbsInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController as Controller;
use Hexmedia\AdministratorBundle\ControllerInterface\ListController as ListControllerInterface;
use Hexmedia\ContentBundle\Form\MediaEditType;
use Hexmedia\ContentBundle\Form\MediaAddType;
use Hexmedia\ContentBundle\Entity\Media;

class MediaController extends Controller implements ListControllerInterface, BreadcrumbsInterface
{

	/**
	 * @var WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs
	 */
	private $breadcrumbs;

	/**
	 * {@inheritDoc}
	 */
	public function registerBreadcrubms()
	{
		$this->breadcrumbs = $this->get("white_october_breadcrumbs");

		$this->breadcrumbs->addItem($this->get('translator')->trans("Media Library"), $this->get('router')->generate('HexMediaMediaLibrary'));

		return $this->breadcrumbs;
	}

	/**
	 * @Rest\View
	 */
	public function addAction()
	{
		$breadcrumbs = $this->registerBreadcrubms();
		$breadcrumbs->addItem("Add");

		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm(new MediaAddType());

		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$media = $form->getData();

			if (!$media->getName() || !strlen(trim($media->getName()))) {
				$media->setName($media->getFile()->getClientOriginalName());
			}

			$media->setLastModified(new \DateTime());
			$media->setCreated(new \DateTime());

			$em->persist($media);

			$em->flush();
		}

		return array('form' => $form->createView());
	}

	/**
	 *
	 * @Rest\View
	 *
	 * @param int $id
	 */
	public function editAction($id)
	{
		$breadcrumbs = $this->registerBreadcrubms();
		$breadcrumbs->addItem("Edit");

		$em = $this->getDoctrine()->getManager();

		$repository = $em->getRepository('HexmediaContentBundle:Media');

		$media = $repository->findOneById($id);

		$form = $this->createForm(new MediaEditType(), $media);

		if ($form instanceof \Symfony\Component\Form\Form)
			;

		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$mediaNew = $form->getData();

			$mediaNew->setLastModified(new \DateTime());

			$em->persist($mediaNew);

			$em->flush();
		}

		return array('form' => $form->createView(), 'media' => $media);
	}

	/**
	 * @param int $id
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

		return array('success' => true);
	}

	public function customizeAction()
	{
		return array();
	}

	/**
	 * @Rest\View
	 */
	public function listAction($page = 1, $pageSize = 10, $sort = 'id', $sortDirection = "ASC")
	{
		$this->registerBreadcrubms();

		$arr = array(
			"entities" => array(),
			"entitiesCount" => $this->getRepository()->getCount()
		);

		$vichHelper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
		$agoHelper = $this->container->get('hexmedia.templating.helper.time_formatter');

		$cacheManager = $this->container->get('liip_imagine.cache.manager');

		$i = ($page - 1) * $pageSize + 1;
		foreach ($this->getRepository()->getPage($page, $sort, $pageSize, $sortDirection) as $entity) {
			$arr['entities'][] = array(
				'id' => $entity->getId(),
				'number' => $i,
				'miniature' => "<img src=\"" . $cacheManager->getBrowserPath($vichHelper->asset($entity, 'file'), 'small_admin_square') . "\" />",
				'lastModified' => $entity->getModified() == null ? $agoHelper->formatTime($entity->getCreated()) : $agoHelper->formatTime($entity->getModified()),
				'name' => $entity->getName()
			);
		}

		return $arr;
	}

	/**
	 * Attaching media
	 *
	 * @param type $page
	 * @param type $pageSize
	 * @param type $sort
	 * @param type $sortDirection
	 *
	 * @Rest\View
	 */
	public function attachAction($page = 1, $pageSize = 10, $sort = 'id', $sortDirection = "ASC")
	{
		$arr = array(
			"entities" => array(),
			"entitiesCount" => $this->getRepository()->getCount()
		);

		$vichHelper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
		$cacheManager = $this->container->get('liip_imagine.cache.manager');

		$i = ($page - 1) * $pageSize + 1;
		foreach ($this->getRepository()->getPage($page, $sort, $pageSize, $sortDirection) as $entity) {
			$arr['entities'][] = array(
				'id' => $entity->getId(),
				'number' => $i,
				'miniature' => "<img src=\"" . $cacheManager->getBrowserPath($vichHelper->asset($entity, 'file'), 'attach_admin_square') . "\" />",
				'name' => $entity->getName()
			);
		}

		return $arr;
	}

	/**
	 * @return Hexmedia\UserBundle\Repository\MediaRepository
	 */
	private function getRepository()
	{
		$em = $this->getDoctrine()->getManager();

		/**
		 * @var Hexmedia\UserBundle\Repository\MediaRepository
		 */
		$repository = $em->getRepository('HexmediaContentBundle:Media');

		return $repository;
	}

}
