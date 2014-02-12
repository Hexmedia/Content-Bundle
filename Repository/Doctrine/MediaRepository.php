<?php

namespace Hexmedia\ContentBundle\Repository\Doctrine;

use Hexmedia\AdministratorBundle\Repository\Doctrine\ListTrait;
use Hexmedia\ContentBundle\Repository\MediaRepositoryInterface;
use Hexmedia\AdministratorBundle\Repository\Doctrine\CrudRepository;

class MediaRepository extends CrudRepository implements MediaRepositoryInterface {
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
