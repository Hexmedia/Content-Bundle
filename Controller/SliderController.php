<?php

namespace Hexmedia\ContentBundle\Controller;

use Hexmedia\AdministratorBundle\Controller\CrudController;
use Hexmedia\AdministratorBundle\Controller\ListTrait;
use Hexmedia\AdministratorBundle\ControllerInterface\WhiteOctober;
use Symfony\Component\HttpFoundation\Request;
use Hexmedia\ContentBundle\Entity\Slider;
use Hexmedia\ContentBundle\Form\Type\Slider\AddType;
use Hexmedia\ContentBundle\Form\Type\Slider\EditType;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Slider controller.
 *
 */
class SliderController extends CrudController
{
    /**
     *
     * @return \WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs
     */
    protected function registerBreadcrubms()
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
     *
     * @return \Hexmedia\ContentBundle\Repository\Doctrine\SliderRepository
     */
    protected function getRepository()
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('HexmediaContentBundle:Slider');
    }

    public function getFieldsToDisplayOnList()
    {
        return [
            "number" => ['get' => "number", 'label' => '#'],
            "id" => ['get' => "getId", 'show' => false],
            "name" => ['get' => "getName", 'label' => 'Name'],
            "lastModified" => ['get' => "getUpdatedAt", 'format' => 'timeformat', 'label' => 'Last modified']
        ];
    }

    /**
     * Creates a new Slider entity.
     *
     * @Rest\View(template="HexmediaContentBundle:Slider:add.html.twig")
     */
    public function createAction(Request $request)
    {
        return parent::createAction($request);
    }

    /**
     * Edits an existing Slider entity.
     *
     * @Rest\View(template="HexmediaContentBundle:Slider:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        return parent::updateAction($request, $id);
    }

    /**
     * @param string $ident
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function displayAction($ident, $template = "HexmediaContentBundle:Slider:display.html.twig") {
        /**
         * @var $entity \Hexmedia\ContentBundle\Entity\Slider
         */
        $entity = $this->getRepository()->findOneBySlugWithSlides($ident);

        if (!$entity) {
            throw new NotFoundHttpException("Slider was not found!");
        }

        return $this->render($template, [
                'slider' => $entity,
                'slides' => $entity->getSlides()
            ]);
    }

    protected function getNewEntity()
    {
        return new Slider();
    }

    public function getMainRoute()
    {
        return "HexMediaContentSlider";
    }

    protected function getAddFormType()
    {
        return new AddType();
    }

    public function getEntityName()
    {
        return "Slider";
    }

    protected function getEditFormType()
    {
        return new EditType();
    }
}
