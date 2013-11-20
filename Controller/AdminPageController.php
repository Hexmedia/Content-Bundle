<?php

namespace Hexmedia\ContentBundle\Controller;

use Hexmedia\AdministratorBundle\Controller\CrudController;
use Hexmedia\AdministratorBundle\Controller\ListTrait;
use Hexmedia\AdministratorBundle\ControllerInterface\WhiteOctober;
use Hexmedia\ContentBundle\Form\Type\Page\AddType;
use Hexmedia\ContentBundle\Form\Type\Page\EditType;
use Symfony\Component\HttpFoundation\Request;

use Hexmedia\ContentBundle\Entity\Page;
use Hexmedia\ContentBundle\Form\PageType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Page controller.
 *
 */
class AdminPageController extends CrudController
{
    protected function registerBreadcrubms()
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
    protected function getRepository()
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('HexmediaContentBundle:Page');
    }

    public function getFieldsToDisplayOnList()
    {
        return [
            'id' => ['get' => 'getId', 'show' => false, 'sortable' => false],
            'number' => ['get' => 'number', 'label' => '#' ],
            'title' => ['get' => 'getTitle', 'label' => 'Title' ],
            'slug' => ['get' => 'getSlug', 'label' => 'Slug' ],
            'published' => ['get' => 'getPublished', 'format' => 'bool', 'label' => 'Published'],
            'publishedFrom' => ['get' => 'getPublishedFrom', 'format' => 'timeformat', 'label' => 'Published From'],
            'publishedTo' => ['get' => 'getPublishedTo', 'format' => 'timeformat', 'label' => 'Published To'],
            'lastModified' => ['get' => 'getUpdatedAt', 'format' => 'timeformat', 'label' => 'Last Modified']
        ];
    }

    /**
     * Creates a new Page entity.
     *
     * @Rest\View(template="HexmediaContentBundle:AdminPage:add.html.twig")
     */
    public function createAction(Request $request)
    {
        return parent::createAction($request);
    }
    /**
     * Edits an existing Page entity.
     *
     * @Rest\View(template="HexmediaContentBundle:AdminPage:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        return parent::updateAction($request, $id);
    }

    protected function getNewEntity()
    {
        return new Page();
    }

    public function getRouteName()
    {
        return "HexMediaContentPage";
    }

    protected function getAddFormType()
    {
        return new AddType();
    }

    public function getEntityName()
    {
        return "Page";
    }

    protected function getEditFormType()
    {
        return new EditType();
    }

    protected function getListTemplate() {
        return "HexmediaContentBundle:AdminPage";
    }
}
