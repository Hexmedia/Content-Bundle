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

/**
 * Page controller.
 *
 */
class PageController extends CrudController
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

    protected function getFieldsToDisplayOnList()
    {
        return [
            'id' => 'getId',
            'number' => 'number',
            'title' => 'getTitle',
            'slug' => 'getSlug',
            'published' => ['get' => 'getPublished', 'format' => 'bool'],
            'publishedFrom' => ['get' => 'getPublishedFrom', 'format' => 'timeformat'],
            'publishedTo' => ['get' => 'getPublishedTo', 'format' => 'timeformat'],
            'lastModified' => ['get' => 'getUpdatedAt', 'format' => 'timeformat']
        ];
    }

    /**
     * Creates a new Page entity.
     *
     * @Rest\View(template="HexmediaContentBundle:Page:add.html.twig")
     */
    public function createAction(Request $request)
    {
        return parent::createAction($request);
    }
    /**
     * Edits an existing Page entity.
     *
     * @Rest\View(template="HexmediaContentBundle:Page:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        return parent::updateAction($request, $id);
    }

    /**
     * @param string $ident
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function displayAction($ident, $template = "HexmediaContentBundle:Page:display.html.twig") {
        $entity = $this->getRepository()->findOneBySlug($ident);

        return $this->render($template, [
                'page' => $entity
            ]);
    }

    protected function getNewEntity()
    {
        return new Page();
    }

    protected function getMainRoute()
    {
        return "HexMediaContentPage";
    }

    protected function getAddFormType()
    {
        return new AddType();
    }

    protected function getEntityName()
    {
        return "Page";
    }

    protected function getEditFormType()
    {
        return new EditType();
    }
}
