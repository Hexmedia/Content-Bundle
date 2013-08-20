<?php

namespace Hexmedia\ContentBundle\Repository\Doctrine;

use Doctrine\ORM\EntityRepository;
use Hexmedia\ContentBundle\Repository\MediaRepositoryInterface;

class MediaRepository extends EntityRepository implements MediaRepositoryInterface {

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
