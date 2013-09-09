<?php

namespace Hexmedia\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Slide
 *
 * @ORM\Table(name="slide")
 * @ORM\Entity(repositoryClass="Hexmedia\ContentBundle\Repository\Doctrine\SlideRepository")
 */
class Slide
{
    use ORMBehaviors\Timestampable\Timestampable,
        ORMBehaviors\Blameable\Blameable,
        ORMBehaviors\Loggable\Loggable,
        ORMBehaviors\Sortable\Sortable;

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
     * @ORM\Column(name="subtitle", type="string", length=255)
     */
    private $subtitle;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=5000)
     */
    private $description;
    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255)
     */
    private $link;
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
     * @var \Hexmedia\ContentBundle\Entity\Slider
     *
     * @ORM\ManyToOne(targetEntity="Hexmedia\ContentBundle\Entity\Slider", inversedBy="slides")
     * @ORM\JoinColumn(name="slider_id", referencedColumnName="id", nullable=false)
     */
    private $slider;
    /**
     * @var \Hexmedia\ContentBundle\Entity\Media
     *
     * @ORM\ManyToMany(targetEntity="Hexmedia\ContentBundle\Entity\Media")
     * @ORM\JoinTable(name="slide_has_media",
     *        joinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id")},
     *        inverseJoinColumns={@ORM\JoinColumn(name="media_id", referencedColumnName="id")}
     *    )
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
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Slide
     */
    public function setTitle($title)
    {
        $this->title = $title;

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
     * Set subtitle
     *
     * @param string $subtitle
     * @return Slide
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

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
     * Set description
     *
     * @param string $description
     * @return Slide
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Slide
     */
    public function setLink($link)
    {
        $this->link = $link;

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
     * Set published
     *
     * @param boolean $published
     * @return Slide
     */
    public function setPublished($published)
    {
        $this->published = $published;

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
     * Set publishedFrom
     *
     * @param \DateTime $publishedFrom
     * @return Slide
     */
    public function setPublishedFrom($publishedFrom)
    {
        $this->publishedFrom = $publishedFrom;

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
     * Set publishedTo
     *
     * @param \DateTime $publishedTo
     * @return Slide
     */
    public function setPublishedTo($publishedTo)
    {
        $this->publishedTo = $publishedTo;

        return $this;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Slide
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Slide
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     * @return Slide
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return integer
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Get slider
     *
     * @return \Hexmedia\ContentBundle\Entity\Slider
     */
    public function getSlider()
    {
        return $this->slider;
    }

    /**
     * Set slider
     *
     * @param \Hexmedia\ContentBundle\Entity\Slider $slider
     * @return Slide
     */
    public function setSlider(\Hexmedia\ContentBundle\Entity\Slider $slider)
    {
        $this->slider = $slider;

        return $this;
    }

    /**
     * Add media
     *
     * @param \Hexmedia\ContentBundle\Entity\Media $media
     * @return Slide
     */
    public function addMedia(\Hexmedia\ContentBundle\Entity\Media $media)
    {
        $this->media[] = $media;

        return $this;
    }

    /**
     * Remove media
     *
     * @param \Hexmedia\ContentBundle\Entity\Media $media
     */
    public function removeMedia(\Hexmedia\ContentBundle\Entity\Media $media)
    {
        $this->media->removeElement($media);
    }

    /**
     * Get media
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMedia()
    {
        return $this->media;
    }
}