<?php

namespace Hexmedia\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Hexmedia\ContentBundle\Locale\Entity as LocaleEntity;

/**
 * Gallery
 *
 * @ORM\Entity(repositoryClass="Hexmedia\ContentBundle\Repository\Doctrine\GalleryRepository")
 * @ORM\Table(name="galleries")
 * @Gedmo\Loggable
 */
class Gallery implements LocaleEntity
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
	 * @ORM\Column(name="name", type="string", length=255)
	 * @Gedmo\Translatable
	 */
	private $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="slug", type="string", length=255, unique=true)
	 * @Gedmo\Slug(fields={"name"})
	 * @Gedmo\Translatable
	 */
	private $slug;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="description", type="string", length=500)
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
	 * @ORM\Column(name="modified", type="datetime", nullable=true)
	 * @Gedmo\Timestampable(on="update")
	 */
	private $modified;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\ManyToMany(targetEntity="Hexmedia\ContentBundle\Entity\Media", inversedBy="galleries")
	 * @ORM\JoinTable(name="gallery_has_media")
	 */
	private $media;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->media = new \Doctrine\Common\Collections\ArrayCollection();
	}

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
	 * @return Gallery
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
	 * Set slug
	 *
	 * @param string $slug
	 * @return Gallery
	 */
	public function setSlug($slug)
	{
		$this->slug = $slug;
		return $this;
	}

	/**
	 * Get slug
	 *
	 * @return string
	 */
	public function getSlug()
	{
		return $this->slug;
	}

	/**
	 * Set description	public function setGallery($gallery) {

	 *
	 * @param string $description
	 * @return Gallery
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
	 * @return Gallery
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
	 * @return Gallery
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
	 * Add media to gallery
	 *
	 * @param Media $media
	 * @return Gallery
	 */
	public function addMedia(Media $media)
	{
		$this->media[] = $media;
		$media->addGallery($this);

		return $this;
	}

	/**
	 * Remove media
	 *
	 * @param Media $media
	 */
	public function removeMedia(Media $media)
	{
		$this->media->removeElement($media);
		$media->removeGallery($this);
	}

	/**
	 * Returns all media
	 *
	 * @return ArrayCollection
	 */
	public function getMedia()
	{
		return $this->media;
	}

	public function __toString()
	{
		return $this->slug;
	}

	/**
	 * Set locale for translations
	 *
	 * @param string $locale
	 * @return Gallery
	 */
	public function setTranslatableLocale($locale)
	{
		$this->locale = $locale;
		return $this;
	}

}

