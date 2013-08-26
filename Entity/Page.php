<?php

namespace Hexmedia\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hexmedia\UserBundle\Entity\User;
use Hexmedia\ContentBundle\Locale\Entity as LocaleEntity;

/**
 * Page
 *
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="Hexmedia\ContentBundle\Repository\Entity\PageRepository")

 */
class Page
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
	 * @ORM\Column(name="title", type="string", length=255)
	 */
	private $title;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="slug", type="string", length=255)
	 */
	private $slug;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created", type="datetime")
	 */
	private $created;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="modified", type="datetime", nullable=true)
	 */
	private $modified;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="teaser", type="string", length=500)
	 */
	private $teaser;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="content", type="string", length=10000)
	 */
	private $content;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="seo_title", type="string", length=255, nullable=true)
	 */
	private $seoTitle;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="seo_keywords", type="string", length=500, nullable=true)
	 */
	private $seoKeywords;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="seo_description", type="string", length=500, nullable=true)
	 */
	private $seoDescription;

	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity="Hexmedia\UserBundle\Entity\User")
	 * @ORM\JoinColumn(name="admin_id", referencedColumnName="id", nullable=false)
	 */
	private $admin;

	/**
	 * @var Media
	 *
	 * @ORM\ManyToMany(targetEntity="Hexmedia\ContentBundle\Entity\Media")
	 * @ORM\JoinTable(name="page_has_media",
	 * 		joinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id")},
	 * 		inverseJoinColumns={@ORM\JoinColumn(name="media_id", referencedColumnName="id")}
	 * 	)
	 */
	private $media;

	/**
	 * @var Category
	 *
	 * @ORM\ManyToMany(targetEntity="Hexmedia\ContentBundle\Entity\Category")
	 * @ORM\JoinTable(name="category_has_page",
	 * 		joinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id")},
	 * 		inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
	 * 	)
	 */
	private $categories;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->media = new \Doctrine\Common\Collections\ArrayCollection();
		$this->categories = new \Doctrine\Common\Collections\ArrayCollection();
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
	 * Set title
	 *
	 * @param string $title
	 * @return Page
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
	 * Set teaser
	 *
	 * @param string $teaser
	 * @return Page
	 */
	public function setTeaser($teaser)
	{
		$this->teaser = $teaser;

		return $this;
	}

	/**
	 * Get teaser
	 *
	 * @return string
	 */
	public function getTeaser()
	{
		return $this->teaser;
	}

	/**
	 * Set content
	 *
	 * @param string $content
	 * @return Page
	 */
	public function setContent($content)
	{
		$this->content = $content;

		return $this;
	}

	/**
	 * Get content
	 *
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * Set seoTitle
	 *
	 * @param string $seoTitle
	 * @return Page
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
	 * @return Page
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
	 * @return Page
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
	 * Set admin
	 *
	 * @param string $admin
	 * @return Page
	 */
	public function setAdmin($admin)
	{
		$this->admin = $admin;

		return $this;
	}

	/**
	 * Get admin
	 *
	 * @return string
	 */
	public function getAdmin()
	{
		return $this->admin;
	}

	/**
	 * Add media
	 *
	 * @param Media $media
	 * @return Page
	 */
	public function addMedia(Media $media)
	{
		$this->media[] = $media;

		return $this;
	}

	/**
	 *
	 * @param Media $media
	 * @return Page
	 */
	public function removeMedia(Media $media)
	{

		return $this;
	}

	/**
	 * Get media
	 *
	 * @return string
	 */
	public function getMedia()
	{
		return $this->media;
	}

	/**
	 * Add categories
	 *
	 * @param \Hexmedia\ContentBundle\Entity\Category $categories
	 * @return Page
	 */
	public function addCategorie(\Hexmedia\ContentBundle\Entity\Category $categories)
	{
		$this->categories[] = $categories;

		return $this;
	}

	/**
	 * Remove categories
	 *
	 * @param \Hexmedia\ContentBundle\Entity\Category $categories
	 */
	public function removeCategorie(\Hexmedia\ContentBundle\Entity\Category $categories)
	{
		$this->categories->removeElement($categories);
	}

	/**
	 * Get categories
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getCategories()
	{
		return $this->categories;
	}

}

