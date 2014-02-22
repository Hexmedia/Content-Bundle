<?php

namespace Hexmedia\ContentBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Hexmedia\ContentBundle\Form\Type\Media\AddType;
use Hexmedia\ContentBundle\Form\Type\Media\EditType;
use Hexmedia\ContentBundle\Entity\Media;
use Hexmedia\ContentBundle\Form\Type\Media\UploadForm;
use Symfony\Component\HttpFoundation\Request;
use Hexmedia\AdministratorBundle\Controller\CrudController as Controller;

class AdminMediaController extends Controller
{
    /**
     * {@inheritDoc}
     */
    protected function registerBreadcrubms()
    {
        $this->breadcrumbs = $this->get("white_october_breadcrumbs");

        $this->breadcrumbs->addItem($this->get('translator')->trans("Content"));
        $this->breadcrumbs->addItem($this->get('translator')->trans("Media Library"), $this->get('router')->generate('HexMediaContentMedia'));

        return $this->breadcrumbs;
    }

    /**
     * @param int $page
     *
     * @Rest\View
     */
    public function indexAction($page = 1)
    {

    }

    /**
     * @param int $page
     *
     * @Rest\View
     */
    public function listAction($page = 1)
    {
        $query = $this->getRepository()->getToPaginator();

        $paginator = $this->get("knp_paginator");

        if ($paginator instanceof \Knp\Component\Pager\Paginator) ;

        $pagination = $paginator->paginate(
            $query,
            $page,
            30
        );

        $pagination->setTemplate('KnpPaginatorBundle:Pagination:twitter_bootstrap_v3_pagination.html.twig');

        return [
            'page' => $page,
            'pagination' => $pagination
        ];
    }

    /**
     * Attaching media
     *
     * @Rest\View
     */
    public function attachAction($page = 1, $single = 'single', $type = 'image')
    {
        $query = $this->getRepository()->getToPaginator();

        $paginator = $this->get("knp_paginator");

        if ($paginator instanceof \Knp\Component\Pager\Paginator) ;

        $pagination = $paginator->paginate(
            $query,
            $page,
            12
        );

        $pagination->setTemplate('KnpPaginatorBundle:Pagination:twitter_bootstrap_v3_pagination.html.twig');

        return [
            'page' => $page,
            'pagination' => $pagination,
            'single' => $single == 'single',
            'type' => $type
        ];
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Rest\View
     */
    public function multipleAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(new UploadForm());

        if ($form instanceof \Symfony\Component\Form\Form) ;

        if ($request->getMethod() == "POST") {
            $form->handleRequest($request);
            if ($form->isValid()) {
                foreach ($form->getData("files") as $file) {
                    $media = new Media();
                    $media->setFile($file);

                    $entityManager->persist($media);
                }

                $this->get('session')->getFlashBag()->add('notice', 'Files has beed uploaded.');

                $entityManager->flush();

                return $this->redirect($this->get("router")->generate("HexMediaContentMedia"));
            } else {
                $this->get('session')->getFlashBag()->add('error', 'Files has not beed uploaded.');
            }
        }

        return [
            'form' => $form
        ];
    }

    protected function getRepository()
    {
        return $this->getDoctrine()->getRepository("HexmediaContentBundle:Media");
    }

    protected function getAddFormType()
    {
        return new AddType();
    }

    protected function getEditFormType()
    {
        return new EditType();
    }

    public function getRouteName()
    {
        return "HexMediaContentMedia";
    }

    public function getEntityName()
    {
        return "Media";
    }

    public function getListTemplate()
    {
        return "UNSUSED";
    }

    public function getNewEntity()
    {
        return new Media();
    }
}
