<?php

namespace Hexmedia\ContentBundle\Repository\Doctrine;

use Doctrine\ORM\EntityRepository;
use Hexmedia\ContentBundle\Repository\GalleryRepositoryInterface;

/**
 * GalleryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GalleryRepository extends EntityRepository implements GalleryRepositoryInterface {

	public function getPage($page = 1, $sort = 'id', $pageSize = 10, $sortDirection = 'ASC', $fields = array()) {
		$queryBuilder = $this->createQueryBuilder('t')
			->setMaxResults($pageSize)
			->setFirstResult(max(0, $page - 1) * $pageSize)
			->orderBy('t.' . $sort, $sortDirection == 'ASC' ? 'ASC' : 'DESC')
		;

		return $queryBuilder->getQuery()->getResult();
	}

	public function getCount() {
		$queryBuilder = $this->createQueryBuilder("t")
			->select("count(t.id)");

		return $queryBuilder->getQuery()->getSingleScalarResult();
	}

}