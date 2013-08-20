<?php

namespace Hexmedia\ContentBundle\Entity;

use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Hexmedia\ContentBundle\Locale\Entity as LocaleEntity;

/**
 * Media
 *
 * @Vich\Uploadable
 *
 * @ORM\Entity(repositoryClass="Hexmedia\ContentBundle\Repository\Doctrine\MediaRepository")
 * @ORM\Table(name="media")
 * @Gedmo\Loggable
 */
class Media implements LocaleEntity
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
	protected $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 * @Gedmo\Translatable
	 */
	protected $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="description", type="string", length=5000, nullable=true)
	 * @Gedmo\Translatable
	 */
	protected $description;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created", type="datetime")
	 * @Gedmo\Timestampable(on="create")
	 */
	protected $created;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="modified", type="datetime", nullable=true)
	 * @Gedmo\Timestampable(on="update")
	 */
	private $modified;

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
	 * Set created
	 *
	 * @param \DateTime $created
	 * @return Media
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
	 * @return Media
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
}