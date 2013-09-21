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

    public function findByPath($path)
    {
        $repository = $this->entityManager->getRepository("HexmediaContentBundle:Area");

        $md5 = substr($path, 0, strpos($path, ":"));

        return $repository->getByMd5($md5);
    }

    public function getField($path)
    {
        return "content";
    }
}