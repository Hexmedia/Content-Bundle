<?php

namespace Hexmedia\ContentBundle\Repository;

use Hexmedia\AdministratorBundle\Repository\ListRepositoryInterface;

interface AreaRepositoryInterface extends ListRepositoryInterface
{
    function getByNameAndPath($name, $path);
    function getGlobalByName($name);
    function getByPath($path);
}

?>
