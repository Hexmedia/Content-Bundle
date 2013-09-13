<?php

namespace Hexmedia\ContentBundle\Controller;

use Hexmedia\AdministratorBundle\Controller\ListTrait;
use Hexmedia\AdministratorBundle\ControllerInterface\BreadcrumbsInterface;
use Hexmedia\AdministratorBundle\ControllerInterface\ListController;
use Hexmedia\AdministratorBundle\ControllerInterface\WhiteOctober;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController as Controller;
use Hexmedia\ContentBundle\Entity\Slider;
use Hexmedia\ContentBundle\Form\Type\Slider\AddType;
use Hexmedia\ContentBundle\Form\Type\Slider\EditType;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Slider controller.
 *
 */
class SliderController extends Controller implements ListController, BreadcrumbsInterface
{
    use ListTrait;

    /**
     * @var \WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs
     */
    private $breadcrumbs;

    /**
     * @return array
     *
     * @Rest\View
     */
    public function indexAction()
    {
        $this->registerBreadcrubms();

        return [];
    }

    /**
     *
     * @return WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs
     */
    public function registerBreadcrubms()
    {
        $this->breadcrumbs = $this->get("white_october_breadcrumbs");

        $this->breadcrumbs->addItem($this->get('translator')->trans("Content"));
        $this->breadcrumbs->addItem(
            $this->get('translator')->trans("Slider"),
            $this->get('router')->generate('HexMediaContentSlider')
        );

        return $this->breadcrumbs;
    }

    /**
     * Lists all Slider entities.
     *
     * @Rest\View
     */
    public function listAction($page = 1, $pageSize = 10, $sort = 'id', $sortDirection = "ASC")
    {
        $entities = $this->getRepository()->getPage($page, $sort, $pageSize, $sortDirection);
        $entitesRet = $this->prepareEntities($entities);

        return [
            'entities' => $entitesRet,
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

        return $em->getRepository('HexmediaContentBundle:Slider');
    }

    public function getFieldsToDisplayOnList()
    {
        return [
            "number" => "number",
            "id" => "getId",
            "name" => "getName",
            "lastModified" => ['get' => "getUpdatedAt", 'format' => 'timeformat']
        ];
    }

    /**
     * Creates a new Slider entity.
     *
     * @Rest\View(template="HexmediaContentBundle:Slider:add.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Slider();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Slider has been added!');

            if ($form->get("saveAndExit")->isClicked()) {
                return $this->redirect($this->generateUrl('HexMediaContentSlider'));
            } else {
                return $this->redirect($this->generateUrl('HexMediaContentSliderEdit', ['id' => $entity->getId()]));
            }

            return $this->redirect($this->generateUrl('slider_show', ['id' => $entity->getId()]));
        }

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Creates a form to create a Slider entity.
     *
     * @param Slider $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Slider $entity)
    {
        $form = $this->createForm(
            new AddType(),
            $entity,
            [
                'action' => $this->generateUrl('HexMediaContentSliderCreate'),
                'method' => 'POST',
            ]
        );

        return $form;
    }

    /**
     * Displays a form to create a new Slider entity.
     *
     * @Rest\View
     */
    public function addAction()
    {
        $entity = new Slider();
        $form = $this->createCreateForm($entity);

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Finds and displays a Slider entity.
     *
     * @Rest\View
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HexmediaContentBundle:Slider')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slider entity.');
        }

        return [
            'entity' => $entity
        ];
    }

    /**
     * Displays a form to edit an existing Slider entity.
     *
     * @Rest\View()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HexmediaContentBundle:Slider')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slider entity.');
        }

        $form = $this->createEditForm($entity);

        return [
            'entity' => $entity,
            'form' => $form->createView()
        ];
    }

    /**
     * Creates a form to edit a Slider entity.
     *
     * @param Slider $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Slider $entity)
    {
        $form = $this->createForm(
            new EditType(),
            $entity,
            [
                'action' => $this->generateUrl('HexMediaContentSliderUpdate', ['id' => $entity->getId()]),
                'method' => 'PUT',
            ]
        );

        return $form;
    }

    /**
     * Edits an existing Slider entity.
     *
     * @Rest\View(template="HexmediaContentBundle:Slider:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HexmediaContentBundle:Slider')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slider entity.');
        }

        $form = $this->createEditForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($em->getUnitOfWork()->isScheduledForUpdate($entity)) {
                $this->get('session')->getFlashBag()->add('notice', 'Slider has been updated!');
            }

            $em->flush();

            if ($form->get("saveAndExit")->isClicked()) {
                return $this->redirect($this->generateUrl('HexMediaContentSlider'));
            } else {
                return $this->redirect($this->generateUrl('HexMediaContentSliderEdit', ['id' => $entity->getId()]));
            }
        }

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Deletes a Slider entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slider entity.');
        }
        $em = $this->getDoctrine()->getManager();

        $em->remove($entity);

        $em->flush();

        return ['success' => true];
    }
}
