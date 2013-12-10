<?php

namespace Hexmedia\ContentBundle\Repository\Doctrine;

use Doctrine\ORM\NoResultException;
use Hexmedia\AdministratorBundle\Repository\Doctrine\CrudRepository;
use Hexmedia\AdministratorBundle\Repository\Doctrine\ListTrait;
use Hexmedia\ContentBundle\Repository\AreaRepositoryInterface;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AreaRepository extends CrudRepository implements AreaRepositoryInterface
{
    use ListTrait;

    /**
     * @param $name
     * @param $path
     * @return mixed
     */
    public function getByNameAndPath($name, $path)
    {
        $queryBuilder = $this->createQueryBuilder("a");

        $queryBuilder
            ->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq('a.name', ':name'),
                    $queryBuilder->expr()->eq('a.path', ':path')
                )
            )
            ->setParameter(':name', $name)
            ->setParameter(':path', $path);

        try {
            return $queryBuilder->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }

    public function getByPath($path)
    {
        return $this->findOneByPath($path);
    }

    public function getGlobalByName($name)
    {
        $queryBuilder = $this->createQueryBuilder("a");

        $queryBuilder
            ->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq('a.name', ':name'),
                    $queryBuilder->expr()->eq('a.global', 1)
                )

            )
            ->setParameter(':name', $name);

        try {
            return $queryBuilder->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }

    }

    public function getByMd5($md5)
    {
        return $this->findOneByMd5($md5);
    }
}
