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
     *
     * @Rest\View
     */
    public function listAction($page = 1, $pageSize = 10, $sort = 'id', $sortDirection = "ASC")
    {
        return array_merge(
            parent::listAction($page, $pageSize, $sort, $sortDirection),
            ['sliderId' => $this->getRequest()->get("sliderId")]
        );
    }

    /**
     * Creates a new Slide entity.
     *
     * @Rest\View(template="HexmediaContentBundle:Slide:add.html.twig")
     */
    public function createAction(Request $request)
    {
        return array_merge(parent::createAction($request), ['sliderId' => $this->getRequest()->get("sliderId")]);
    }

    /**
     * {@inheritdoc}
     *
     * @Rest\View
     */
    public function addAction()
    {
        return array_merge(
            parent::addAction(),
            ['sliderId' => $this->getRequest()->get("sliderId")]
        );
    }

    /**
     * {@inheritdoc}
     *
     * @Rest\View
     */
    public function editAction($id)
    {
        return array_merge(
            parent::editAction($id),
            ['sliderId' => $this->getRequest()->get("sliderId")]
        );
    }

    /**
     * Edits an existing Slide entity.
     *
     * @Rest\View(template="HexmediaContentBundle:Slide:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        return array_merge(
            parent::updateAction($request, $id),
            ['sliderId' => $this->getRequest()->get("sliderId")]
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function registerBreadcrubms()
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
     *
     * @return \Hexmedia\ContentBundle\Repository\Doctrine\PageRepository
     */
    protected function getRepository()
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('HexmediaContentBundle:Slide');
    }

    public function getFieldsToDisplayOnList()
    {
        return [
            "number" =>['get' =>  "number", 'label' => '#', 'sortable' => false],
            "id" => ['get' => "getId", 'show' => false],
            "title" => ['get' => "getTitle", 'label' => 'Title'],
            'published' => ['get' => 'getPublished', 'format' => 'bool', 'label' => 'Published'],
            'publishedFrom' => ['get' => 'getPublishedFrom', 'format' => 'timeformat', 'label' => 'Published From'],
            'publishedTo' => ['get' => 'getPublishedTo', 'format' => 'timeformat', 'label' => 'Published To'],
            "lastModified" => ['get' => "getUpdatedAt", 'format' => 'timeformat', 'label' => 'Last Modified']
        ];
    }

    protected function getRouteAdditionalParameters()
    {
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

    public function getMainRoute()
    {
        return "HexMediaContentSlide";
    }

    public function getEntityName()
    {
        return "slide";
    }

    protected function getEditFormType()
    {
        return new EditType();
    }
}
