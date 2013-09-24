<?php

namespace Hexmedia\ContentBundle\Repository\Doctrine;

use Doctrine\ORM\EntityRepository;
use Hexmedia\AdministratorBundle\Repository\Doctrine\ListTrait;
use Hexmedia\ContentBundle\Repository\PageRepositoryInterface;

/**
 * PageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PageRepository extends EntityRepository implements PageRepositoryInterface {
    use ListTrait;

    /**
     * {@inheritdoc}
     */
    public function createPageQueryBuilder($alias) {
        return $this->createQueryBuilder($alias)->where($alias . ".special = 0");
    }
}
