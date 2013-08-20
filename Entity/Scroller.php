<?php

namespace Hexmedia\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Hexmedia\ContentBundle\Locale\Entity as LocaleEntity;

/**
 * Scroller
 *
 * @ORM\Table(name="scroller")
 * @ORM\Entity(repositoryClass="Hexmedia\ContentBundle\Repository\Doctrine\ScrollerRepository")
 *
 * @Gedmo\Loggable
 */
class Scroller implements LocaleEntity
{

	/**
	 * Default locale
	 *
	 * @var string
	 *
	 * @Gedmo\Locale
	 */
	private $locale = 'pl';

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
	 * @ORM\Column(name="title", type="string", length=255)
	 * @Gedmo\Translatable
	 */
	private $title;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="subtitle", type="string", length=255)
	 * @Gedmo\Translatable
	 */
	private $subtitle;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="description", type="string", length=5000)
	 * @Gedmo\Translatable
	 */
	private $description;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created", type="datetime")
	 * @Gedmo\Timestampable(on="create")
	 */
	private $created;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="modified", type="datetime")
	 * @Gedmo\Timestampable(on="update")
	 */
	private $modified;

	/**
	 * @var Hexmedia\UserBundle\Entity\User
	 *
	 * @ORM\ManyToOne(targetEntity="Hexmedia\UserBundle\Entity\User")
	 * @ORM\JoinColumn(name="admin_id", referencedColumnName="id", nullable=false)
	 */
	private $admin;

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
	 * @var integer
	 *
	 * @ORM\Column(name="sort_order", type="integer")
	 */
	private $sortOrder;

	/**
	 * @var Hexmedia\ContentBundle\Entity\Media
	 *
	 * @ORM\ManyToOne(targetEntity="Hexmedia\ContentBundle\Entity\Media")
	 * @ORM\JoinColumn(name="media_id", referencedColumnName="id", nullable=false)
	 */
	private $media;

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
	 * Set title
	 *
	 * @param string $title
	 * @return Scroller
	 */
	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * Get title
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Set subtitle
	 *
	 * @param string $subtitle
	 * @return Scroller
	 */
	public function setSubtitle($subtitle)
	{
		$this->subtitle = $subtitle;

		return $this;
	}

	/**
	 * Get subtitle
	 *
	 * @return string
	 */
	public function getSubtitle()
	{
		return $this->subtitle;
	}

	/**
	 * Set description
	 *
	 * @param string $description
	 * @return Scroller
	 */
	public function setDescription($description)
	{
		$this->description = $description;

		return $this;
	}

	/**
	 * Get description
	 *
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Set created
	 *
	 * @param \DateTime $created
	 * @return Scroller
	 */
	public function setCreated($created)
	{
		$this->created = $created;

		return $this;
	}

	/**
	 * Get created
	 *
	 * @return \DateTime
	 */
	public function getCreated()
	{
		return $this->created;
	}

	/**
	 * Set modified
	 *
	 * @param \DateTime $modified
	 * @return Scroller
	 */
	public function setModified($modified)
	{
		$this->modified = $modified;

		return $this;
	}

	/**
	 * Get modified
	 *
	 * @return \DateTime
	 */
	public function getModified()
	{
		return $this->modified;
	}

	/**
	 * Set admin
	 *
	 * @param Hexmedia\UserBundle\Entity\User $admin
	 * @return Scroller
	 */
	public function setAdmin(Hexmedia\UserBundle\Entity\User $admin)
	{
		$this->admin = $admin;

		return $this;
	}

	/**
	 * Get admin
	 *
	 * @return Hexmedia\UserBundle\Entity\User
	 */
	public function getAdmin()
	{
		return $this->admin;
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

	/**
	 * Set locale for translations
	 *
	 * @param string $locale
	 * @return Scroller
	 */
	public function setTranslatableLocale($locale)
	{
		$this->locale = $locale;
		return $this;
	}

}