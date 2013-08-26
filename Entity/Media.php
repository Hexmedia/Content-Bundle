<?php

namespace Hexmedia\ContentBundle\Entity;

use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Hexmedia\ContentBundle\Locale\Entity as LocaleEntity;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Media
 *
 * @Vich\Uploadable
 *
 * @ORM\Entity(repositoryClass="Hexmedia\ContentBundle\Repository\Doctrine\MediaRepository")
 * @ORM\Table(name="media")
 */
class Media implements LocaleEntity
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
	protected $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	protected $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="description", type="string", length=5000, nullable=true)
	 */
	protected $description;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="file_name", type="string", length=255)
	 */
	protected $fileName;

	/**
	 * @Assert\File(
	 *     maxSize="1M",
	 *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg", "image/gif"}
	 * )
	 * @Vich\UploadableField(mapping="media", fileNameProperty="fileName")
	 */
	protected $file;

	/**
	 *
	 * @var array
	 *
	 * @ORM\ManyToMany(targetEntity="Hexmedia\ContentBundle\Entity\Gallery", mappedBy="media")
	 *
	 */
	private $galleries;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->galleries = new \Doctrine\Common\Collections\ArrayCollection();
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
	 * @return Media
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
	 * Set description
	 *
	 * @param string $description
	 * @return Media
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
	 * Set media file
	 *
	 * @param object $file
	 * @return Media
	 */
	public function setFile($file)
	{
		$this->file = $file;

		return $this;
	}

	/**
	 * Get media file
	 *
	 * @return string
	 */
	public function getFile()
	{
		return $this->file;
	}

	/**
	 * Set media file name
	 *
	 * @param string $fileName
	 * @return Media
	 */
	public function setFileName($fileName)
	{
		$this->fileName = $fileName;
		return $this;
	}

	/**
	 * Get media file name
	 *
	 * @return string
	 */
	public function getFileName()
	{
		return $this->fileName;
	}

	public function getGalleries()
	{
		return $this->galleries;
	}

	/**
	 * Add galleries
	 *
	 * @param Gallery $gallery
	 * @return Media
	 */
	public function addGallery(Gallery $gallery)
	{
		$this->galleries[] = $gallery;

		return $this;
	}

	/**
	 * Remove gallery
	 *
	 * @param Gallery $gallery
	 */
	public function removeGallery(Gallery $gallery)
	{
		$this->galleries->removeElement($gallery);
	}

	public function __toString()
	{
		return $this->getFileName();
	}

	/**
	 * Set locale for translations
	 *
	 * @param string $locale
	 * @return Product
	 */
	public function setTranslatableLocale($locale)
	{
		$this->locale = $locale;
		return $this;
	}

	/**
	 * Add galleries
	 *
	 * @param \Hexmedia\ContentBundle\Entity\Gallery $galleries
	 * @return Media
	 */
	public function addGallerie(\Hexmedia\ContentBundle\Entity\Gallery $galleries)
	{
		$this->galleries[] = $galleries;

		return $this;
	}

	/**
	 * Remove galleries
	 *
	 * @param \Hexmedia\ContentBundle\Entity\Gallery $galleries
	 */
	public function removeGallerie(\Hexmedia\ContentBundle\Entity\Gallery $galleries)
	{
		$this->galleries->removeElement($galleries);
	}

	public function getSluggableFields()
	{
		return ['name'];
	}

	public function getRegenerateSlugOnUpdate()
	{
		return false;
	}

}

