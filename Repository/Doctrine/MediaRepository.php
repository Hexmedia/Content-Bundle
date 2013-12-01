<?php

namespace Hexmedia\ContentBundle\Repository\Doctrine;

use Doctrine\ORM\EntityRepository;
use Hexmedia\AdministratorBundle\Repository\Doctrine\ListTrait;
use Hexmedia\ContentBundle\Repository\MediaRepositoryInterface;

class MediaRepository extends EntityRepository implements MediaRepositoryInterface {
    use ListTrait;

    public function findInBy(array $fields) {
        $queryBuilder = $this->createQueryBuilder("m");

        $andX = $queryBuilder->expr()->andX();
        foreach ($fields as $field => $values) {
            $andX->add($queryBuilder->expr()->in("m.".$field, $values));
        }

        $queryBuilder->where(
            $andX
        );

        return $queryBuilder->getQuery()->getResult();
    }

}
