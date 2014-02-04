<?php

namespace Hexmedia\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hexmedia\AdministratorBundle\Model as AdmModel;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Page
 *
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="Hexmedia\ContentBundle\Repository\Doctrine\PageRepository")
 */
class Page
{
    use ORMBehaviors\Timestampable\Timestampable,
        AdmModel\SeoProxyTrait,
        AdmModel\PublicationTrait,
        AdmModel\SluggableProxyTrait,
        ORMBehaviors\Blameable\Blameable,
        ORMBehaviors\Loggable\Loggable,
        ORMBehaviors\Translatable\Translatable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * If special do not display on page list
     *
     * @var bool
     *
     * @ORM\Column(name="special", type="boolean", nullable=false)
     */
    private $special = false;
    /**
     * @var Media
     *
     * @ORM\ManyToMany(targetEntity="Hexmedia\ContentBundle\Entity\Media")
     * @ORM\JoinTable(name="page_has_media",
     *        joinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id")},
     *        inverseJoinColumns={@ORM\JoinColumn(name="media_id", referencedColumnName="id")}
     *    )
     */
    private $media;

    /**
     * @var Category
     *
     * @ORM\ManyToMany(targetEntity="Hexmedia\ContentBundle\Entity\Category")
     * @ORM\JoinTable(name="category_has_page",
     *        joinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id")},
     *        inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     *    )
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
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->proxyCurrentLocaleTranslation("getTitle");
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Page
     */
    public function setTitle($title)
    {
        $this->proxyCurrentLocaleTranslation("setTitle", [$title]);

        return $this;
    }

    /**
     * Get teaser
     *
     * @return string
     */
    public function getTeaser()
    {
        return $this->proxyCurrentLocaleTranslation("getTeaser");
    }

    /**
     * Set teaser
     *
     * @param string $teaser
     * @return Page
     */
    public function setTeaser($teaser)
    {
        $this->proxyCurrentLocaleTranslation("setTeaser", [$teaser]);

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->proxyCurrentLocaleTranslation("getContent");
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Page
     */
    public function setContent($content)
    {
        $this->proxyCurrentLocaleTranslation("setContent", [$content]);

        return $this;
    }

    /**
     * @param boolean $special
     */
    public function setSpecial($special)
    {
        $this->special = $special;
    }

    /**
     * @return boolean
     */
    public function getSpecial()
    {
        return $this->special;
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
     * @param \Hexmedia\ContentBundle\Entity\Category $category
     * @return Page
     */
    public function addCategory(\Hexmedia\ContentBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Hexmedia\ContentBundle\Entity\Category $category
     */
    public function removeCategory(\Hexmedia\ContentBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
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

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getTitle();
    }

    public function getDefaultLanguage() {
        return "pl";
    }
}

