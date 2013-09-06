<?php

namespace Hexmedia\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Slider
 *
 * @ORM\Table(name="slider")
 * @ORM\Entity(repositoryClass="Hexmedia\ContentBundle\Repository\Doctrine\ScrollerRepository")
 */
class Slider
{

	use ORMBehaviors\Timestampable\Timestampable,
	 ORMBehaviors\Blameable\Blameable,
	 ORMBehaviors\Loggable\Loggable,
	 ORMBehaviors\Sluggable\Sluggable,
	 ORMBehaviors\Sortable\Sortable
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
	 * @var boolean
	 *
	 * @ORM\Column(name="published", type="boolean")
	 */
	private $published;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="published_from", type="datetime")
	 */
	private $publishedFrom;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="published_to", type="datetime")
	 */
	private $publishedTo;

	/**
	 * @var \Hexmedia\ContentBundle\Entity\Slide
	 *
	 * @ORM\ManyToOne(targetEntity="Hexmedia\ContentBundle\Entity\Slide", inversedBy="slide")
	 * @ORM\JoinColumn(name="slider_id", referencedColumnName="id", nullable=false)
	 */
    private $slides;

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
	 * Set published
	 *
	 * @param boolean $published
	 * @return Scroller
	 */
	public function setPublished($published)
	{
		$this->published = $published;

		return $this;
	}

	/**
	 * Get published
	 *
	 * @return boolean
	 */
	public function getPublished()
	{
		return $this->published;
	}

	/**
	 * Set publishedFrom
	 *
	 * @param \DateTime $publishedFrom
	 * @return Scroller
	 */
	public function setPublishedFrom($publishedFrom)
	{
		$this->publishedFrom = $publishedFrom;

		return $this;
	}

	/**
	 * Get publishedFrom
	 *
	 * @return \DateTime
	 */
	public function getPublishedFrom()
	{
		return $this->publishedFrom;
	}

	/**
	 * Set publishedTo
	 *
	 * @param \DateTime $publishedTo
	 * @return Scroller
	 */
	public function setPublishedTo($publishedTo)
	{
		$this->publishedTo = $publishedTo;

		return $this;
	}

	/**
	 * Get publishedTo
	 *
	 * @return \DateTime
	 */
	public function getPublishedTo()
	{
		return $this->publishedTo;
	}

	/**
	 * Set sortOrder
	 *
	 * @param integer $sortOrder
	 * @return Scroller
	 */
	public function setSortOrder($sortOrder)
	{
		$this->sortOrder = $sortOrder;

		return $this;
	}

	/**
	 * Get sortOrder
	 *
	 * @return Media
	 */
	public function getSortOrder()
	{
		return $this->sortOrder;
	}

	/**
	 * Set media
	 *
	 * @param Media $media
	 * @return Scroller
	 */
	public function setMedia(Media $media)
	{
		$this->media = $media;

		return $this;
	}

	/**
	 * Get media
	 *
	 * @return integer
	 */
	public function getMedia()
	{
		return $this->media;
	}

	public function getSluggableFields()
	{
		return ['name'];
	}

}

