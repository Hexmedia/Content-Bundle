<?php

namespace Hexmedia\ContentBundle\Repository\Doctrine;

use Doctrine\ORM\EntityRepository;
use Hexmedia\AdministratorBundle\Repository\Doctrine\ListTrait;
use Hexmedia\ContentBundle\Repository\MediaRepositoryInterface;

class MediaRepository extends EntityRepository implements MediaRepositoryInterface {
    use ListTrait;

}
