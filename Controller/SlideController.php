<?php

namespace Hexmedia\ContentBundle\Controller;

use Hexmedia\AdministratorBundle\Controller\CrudController;
use Hexmedia\AdministratorBundle\Controller\ListTrait;
use Hexmedia\AdministratorBundle\ControllerInterface\BreadcrumbsInterface;
use Hexmedia\AdministratorBundle\ControllerInterface\ListController;
use Hexmedia\AdministratorBundle\ControllerInterface\WhiteOctober;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController as Controller;
use Hexmedia\ContentBundle\Entity\Slide;
use Hexmedia\ContentBundle\Form\Type\Slide\AddType;
use Hexmedia\ContentBundle\Form\Type\Slide\EditType;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Slide controller.
 *
 */
class SlideController extends CrudController
{
    /**
     * {@inheritdoc}
     */
    protected  function registerBreadcrubms()
    {
        $this->breadcrumbs = $this->get("white_october_breadcrumbs");

        $this->breadcrumbs->addItem($this->get('translator')->trans("Content"));
        $this->breadcrumbs->addItem(
            $this->get('translator')->trans("Slide")
//            $this->get('router')->generate('HexMediaContentSlide')
        );

        return $this->breadcrumbs;
    }

    /**
     * {@inheritdoc}
     *
     * @Rest\View
     */
    public function listAction($page = 1, $pageSize = 10, $sort = 'id', $sortDirection = "ASC") {
        return array_merge(parent::listAction($page, $pageSize, $sort, $sortDirection),
            ['sliderId' => $this->getRequest()->get("sliderId")]);
    }
    /**
     *
     * @return \Hexmedia\ContentBundle\Repository\Doctrine\PageRepository
     */
    protected function getRepository()
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('HexmediaContentBundle:Slide');
    }

    /**
     * Creates a new Slide entity.
     *
     * @Rest\View(template="HexmediaContentBundle:Slide:add.html.twig")
     */
    public function createAction(Request $request, $sliderId)
    {
        $entity = new Slide();
        $form = $this->createCreateForm($entity, $sliderId);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository("HexmediaContentBundle:Slider");

            $slider = $repo->findOneById($sliderId);

            $entity->setSlider($slider);
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Slide has been added!');

            if ($form->get("saveAndExit")->isClicked()) {
                return $this->redirect(
                    $this->generateUrl('HexMediaContentSlide', ['sliderId' => $entity->getSlider()->getId()])
                );
            } else {
                return $this->redirect($this->generateUrl('HexMediaContentSlideEdit', ['id' => $entity->getId()]));
            }
        }

        return [
            'entity' => $entity,
            'sliderId' => $sliderId,
            'form' => $form->createView(),
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @Rest\View
     */
    public function addAction()
    {
        return array_merge(parent::addAction(),
            ['sliderId' => $this->getRequest()->get("sliderId")]);
    }

    /**
     * {@inheritdoc}
     *
     * @Rest\View
     */
    public function editAction($id)
    {
        return array_merge(parent::editAction($id),
            ['sliderId' => $this->getRequest()->get("sliderId")]);
    }

    /**
     * Edits an existing Slide entity.
     *
     * @Rest\View(template="HexmediaContentBundle:Slide:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        return array_merge(parent::updateAction($request, $id),
            ['sliderId' => $this->getRequest()->get("sliderId")]);
    }

    protected function getFieldsToDisplayOnList()
    {
        return [
            "number" => "number",
            "id" => "getId",
            "title" => "getTitle",
            'published' => ['get' => 'getPublished', 'format' => 'bool'],
            'publishedFrom' => ['get' => 'getPublishedFrom', 'format' => 'timeformat'],
            'publishedTo' => ['get' => 'getPublishedTo', 'format' => 'timeformat'],
            "lastModified" => ['get' => "getUpdatedAt", 'format' => 'timeformat']
        ];
    }

    protected function getRouteAdditionalParameters() {
        return [
            'sliderId' => $this->getRequest()->get('sliderId')
        ];
    }

    protected function getNewEntity()
    {
        return new Slide();
    }

    protected function getAddFormType()
    {
        return new AddType();
    }

    protected function getMainRoute()
    {
        return "HexMediaContentSlide";
    }

    protected function getEntityName()
    {
        return "slide";
    }

    protected function getEditFormType()
    {
        return new EditType();
    }
}
