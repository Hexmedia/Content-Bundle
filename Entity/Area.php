<?php

namespace Hexmedia\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Area
 *
 * @ORM\Table(name="area")
 * @ORM\Entity(repositoryClass="Hexmedia\ContentBundle\Repository\Doctrine\AreaRepository")
 *
 */
class Area
{

	use ORMBehaviors\Timestampable\Timestampable,
	 ORMBehaviors\Blameable\Blameable,
	 ORMBehaviors\Loggable\Loggable,
	 ORMBehaviors\Sluggable\Sluggable
	;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="global", type="boolean")
	 */
	private $global;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="content", type="string", length=5000)
	 */
	private $content;

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 * @return Category
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set if area is global
	 *
	 * @param boolean $global
	 */
	public function setGlobal($global)
	{
		$this->global = $global;
	}

	/**
	 * Check if area is global
	 *
	 * @return boolean
	 */
	public function getGlobal()
	{
		return $this->global;
	}

	/**
	 * Set area content
	 *
	 * @param string $content
	 */
	public function setContent($content)
	{
		$this->content = $content;
	}

	/**
	 * Get area content
	 *
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}

}

