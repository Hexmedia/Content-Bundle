<?php

namespace Hexmedia\ContentBundle\Controller;

use Doctrine\ORM\EntityManager;
use Hexmedia\AdministratorBundle\Controller\CrudController;
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
class AreaController extends CrudController
{
    protected function getMainRoute() {
        return "HexMediaContentArea";
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

    protected function getEntityName() {
        return "Area";
    }

}
