<?php

namespace Hexmedia\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Hexmedia\ContentBundle\Repository\Doctrine\CategoryRepository")
 */
class Category
{

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
	 * @var string
	 *
	 * @ORM\Column(name="slug", type="string", length=255)
	 */
	private $slug;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="description", type="string", length=255)
	 */
	private $description;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="seo_title", type="string", length=255)
	 */
	private $seoTitle;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="seo_keywords", type="string", length=255)
	 */
	private $seoKeywords;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="seo_description", type="string", length=500)
	 */
	private $seoDescription;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created", type="datetime")
	 */
	private $created;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="modified", type="datetime")
	 */
	private $modified;

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
	 * Set slug
	 *
	 * @param string $slug
	 * @return Category
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
	 * Set description
	 *
	 * @param string $description
	 * @return Category
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
	 * Set seoTitle
	 *
	 * @param string $seoTitle
	 * @return Category
	 */
	public function setSeoTitle($seoTitle)
	{
		$this->seoTitle = $seoTitle;

		return $this;
	}

	/**
	 * Get seoTitle
	 *
	 * @return string
	 */
	public function getSeoTitle()
	{
		return $this->seoTitle;
	}

	/**
	 * Set seoKeywords
	 *
	 * @param string $seoKeywords
	 * @return Category
	 */
	public function setSeoKeywords($seoKeywords)
	{
		$this->seoKeywords = $seoKeywords;

		return $this;
	}

	/**
	 * Get seoKeywords
	 *
	 * @return string
	 */
	public function getSeoKeywords()
	{
		return $this->seoKeywords;
	}

	/**
	 * Set seoDescription
	 *
	 * @param string $seoDescription
	 * @return Category
	 */
	public function setSeoDescription($seoDescription)
	{
		$this->seoDescription = $seoDescription;

		return $this;
	}

	/**
	 * Get seoDescription
	 *
	 * @return string
	 */
	public function getSeoDescription()
	{
		return $this->seoDescription;
	}

	/**
	 * Set created
	 *
	 * @param \DateTime $created
	 * @return Category
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
	 * @return Category
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

