<?php

namespace Hexmedia\ContentBundle\Controller;

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
class SlideController extends Controller implements ListController, BreadcrumbsInterface
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
     * @return \WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs
     */
    public function registerBreadcrubms()
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
     * Lists all Slide entities.
     *
     * @Rest\View
     */
    public function listAction($page = 1, $pageSize = 10, $sort = 'id', $sortDirection = "ASC")
    {
        $entities = $this->getRepository()->getPage($page, $sort, $pageSize, $sortDirection);
        $agoHelper = $this->container->get('hexmedia.templating.helper.time_formatter');

        $i = 0;
        $entitesRet = [];

        foreach ($entities as $entity) {
            $r = new \stdClass();
            $r->id = $entity->getId();
            $r->number = ++$i;
            $r->title = $entity->getTitle();
            $r->lastModified = $entity->getUpdatedAt() == null ? $agoHelper->formatTime(
                $entity->getCreatedAt()
            ) : $agoHelper->formatTime($entity->getUpdatedAt());

            $entitesRet[] = (array)$r;
        }

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
     * Creates a form to create a Slide entity.
     *
     * @param Slide $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Slide $entity, $sliderId)
    {
        $form = $this->createForm(
            new AddType(),
            $entity,
            [
                'action' => $this->generateUrl('HexMediaContentSlideCreate', ['sliderId' => $sliderId]),
                'method' => 'POST',
            ]
        );

        return $form;
    }

    /**
     * Displays a form to create a new Slide entity.
     *
     * @Rest\View
     */
    public function addAction($sliderId)
    {
        $entity = new Slide();
        $form = $this->createCreateForm($entity, $sliderId);

        return [
            'entity' => $entity,
            'sliderId' => $sliderId,
            'form' => $form->createView(),
        ];
    }

    /**
     * Finds and displays a Slide entity.
     *
     * @Rest\View
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HexmediaContentBundle:Slide')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slide entity.');
        }

        return [
            'entity' => $entity
        ];
    }

    /**
     * Displays a form to edit an existing Slide entity.
     *
     * @Rest\View()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HexmediaContentBundle:Slide')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slide entity.');
        }

        $form = $this->createEditForm($entity);

        return [
            'entity' => $entity,
            'sliderId' => $entity->getSlider()->getId(),
            'form' => $form->createView()
        ];
    }

    /**
     * Creates a form to edit a Slide entity.
     *
     * @param Slide $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Slide $entity)
    {
        $form = $this->createForm(
            new EditType(),
            $entity,
            [
                'action' => $this->generateUrl('HexMediaContentSlideUpdate', ['id' => $entity->getId()]),
                'method' => 'PUT',
            ]
        );

        return $form;
    }

    /**
     * Edits an existing Slide entity.
     *
     * @Rest\View(template="HexmediaContentBundle:Slide:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HexmediaContentBundle:Slide')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slide entity.');
        }

        $form = $this->createEditForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($em->getUnitOfWork()->isScheduledForUpdate($entity)) {
                $this->get('session')->getFlashBag()->add('notice', 'Slide has been updated!');
            }

            $em->flush();

            if ($form->get("saveAndExit")->isClicked()) {
                return $this->redirect($this->generateUrl('HexMediaContentSlide'));
            } else {
                return $this->redirect($this->generateUrl('HexMediaContentSlideEdit', ['id' => $entity->getId()]));
            }
        }

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Deletes a Slide entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $entity = $this->getRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slide entity.');
        }
        $em = $this->getDoctrine()->getManager();

        $em->remove($entity);

        $em->flush();

        return ['success' => true];
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
}
