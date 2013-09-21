<?php
/**
 * Created by JetBrains PhpStorm.
 * User: krun
 * Date: 21.09.13
 * Time: 00:08
 * To change this template use File | Settings | File Templates.
 */

namespace Hexmedia\ContentBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController as Controller;
use FOS\RestBundle\Controller\Annotations as Rest;

class PageController extends Controller
{
    /**
     * @param string $ident
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Rest\View
     */
    public function displayAction($ident)
    {
        $entity = $this->getRepository()->findOneBySlug($ident);

        if (!$entity) {
            throw new NotFoundHttpException("Page was not found!");
        }

        return [
            'page' => $entity
        ];
    }

    private function getRepository()
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('HexmediaContentBundle:Page');
    }
}