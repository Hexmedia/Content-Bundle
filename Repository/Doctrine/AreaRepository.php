<?php

namespace Hexmedia\ContentBundle\Repository\Doctrine;

use Doctrine\ORM\EntityRepository;
use Hexmedia\ContentBundle\Repository\CategoryRepositoryInterface;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AreaRepository extends EntityRepository implements CategoryRepositoryInterface
{

	public function getCount()
	{

	}

	public function getPage($page = 1, $sort = 'id', $pageSize = 10, $sortDirection = 'ASC', $fields = array())
	{

	}

}
