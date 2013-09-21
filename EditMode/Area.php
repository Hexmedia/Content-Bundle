<?php
/**
 * Created by JetBrains PhpStorm.
 * User: krun
 * Date: 21.09.13
 * Time: 03:06
 * To change this template use File | Settings | File Templates.
 */

namespace Hexmedia\ContentBundle\EditMode;


use Hexmedia\AdministratorBundle\EditMode\EntityUpdater;

class Area extends EntityUpdater {

    public function find($path)
    {
        $repository = $this->entityManager->getRepository("HexmediaContentBundle:Area");

        return $repository->getByMd5($path);
    }

    /**
     * Always content
     *
     * @param $field
     * @return string
     */
    public function getField($field)
    {
        return "content";
    }
}