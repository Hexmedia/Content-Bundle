<?php

namespace Hexmedia\ContentBundle\Controller;

use Hexmedia\AdministratorBundle\Controller\CrudController;
use Hexmedia\AdministratorBundle\Controller\ListTrait;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Hexmedia\ContentBundle\Entity\Area;
use Hexmedia\ContentBundle\Form\Type\Area\AddType;
use Hexmedia\ContentBundle\Form\Type\Area\EditType;

/**
 * Area controller.
 */
class AreaController extends CrudController
{
    public function getMainRoute() {
        return "HexMediaContentArea";
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldsToDisplayOnList()
    {
        return [
            "number" => ['get' => "number", 'type' => 'number', 'label' => '#'],
            "id" => ['get' => "getId", 'show' => false],
            "page" => ['get' => "getPage", 'label' => 'Page'],
            "name" => ['get' => "getName", 'label' => 'Name'],
            "route" => ['get' => "getRoute", 'label' => 'Route'],
            "lastModified" => ['get' => "getUpdatedAt", 'format' => 'timeformat', 'label' => 'Last Modified']
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

    protected function getNewEntity() {
        return new Area();
    }

    protected function getAddFormType() {
        return new AddType();
    }

    protected function getEditFormType() {
        return new EditType();
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @param string $sort
     * @param string $sortDirection
     * @return array
     *
     * @Rest\View
     */
    public function listAction($page = 1, $pageSize = 10, $sort = 'id', $sortDirection = "ASC")
    {
        return parent::listAction($page, $pageSize, $sort, $sortDirection);
    }
    /**
     * @param Request $request
     * @param $id
     *
     * @return array|\Symfony\Component\HttpFoundation\Response

     * @Rest\View(template="HexmediaContentBundle:Area:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        return parent::updateAction($request, $id);
    }

    /**
     * @param Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\Response
     *
     * @Rest\View(template="HexmediaContentBundle:Area:add.html.twig")
     */
    public function createAction(Request $request) {
        return parent::createAction($request);
    }

    /**
     * @return \Hexmedia\ContentBundle\Repository\Doctrine\AreaRepository
     */
    protected function getRepository()
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('HexmediaContentBundle:Area');
    }

    public function getEntityName() {
        return "Area";
    }

}
