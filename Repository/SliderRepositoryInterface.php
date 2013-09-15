<?php

namespace Hexmedia\ContentBundle\Repository;

use Hexmedia\AdministratorBundle\Repository\ListRepositoryInterface;

interface SliderRepositoryInterface extends ListRepositoryInterface
{
    function findOneBySlugWithSlides($slug);
}

?>
