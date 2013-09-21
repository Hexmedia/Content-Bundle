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

class Page extends EntityUpdater {

    public function find($id)
    {
        $repository = $this->entityManager->getRepository("HexmediaContentBundle:Page");

        return $repository->findOneById($id);
    }

    public function getField($path)
    {
        $pos = strpos($path, ":");
        $field = substr($path, $pos + 1);
        return $field;
    }
}