<?php

namespace Hexmedia\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hexmedia\AdministratorBundle\Model\PublicationTrait;
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
        ORMBehaviors\Sortable\Sortable,
        ORMBehaviors\Sluggable\Sluggable,
        PublicationTrait;

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
     * @var string
     *
     * @ORM\Column(name="new", type="boolean")
     */
    private $new;
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
     * @var \Hexmedia\ContentBundle\Entity\Media
     *
     * @ORM\ManyToOne(targetEntity="\Hexmedia\ContentBundle\Entity\Media")
     * @ORM\JoinColumn(name="background_media_id", referencedColumnName="id")
     */
    private $bgImage;

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
     * @return string
     */
    public function getNew()
    {
        return $this->new;
    }

    /**
     * @param string $new
     */
    public function setNew($new)
    {
        $this->new = $new;
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

    /**
     * Get bgImage
     *
     * @return \Hexmedia\ContentBundle\Entity\Media
     */
    public function getBgImage()
    {
        return $this->bgImage;
    }

    /**
     * Set bgImage
     *
     * @param \Hexmedia\ContentBundle\Entity\Media $bgImage
     * @return Slide
     */
    public function setBgImage(\Hexmedia\ContentBundle\Entity\Media $bgImage = null)
    {
        $this->bgImage = $bgImage;

        return $this;
    }

    public function getSluggableFields()
    {
        return ['title'];
    }

    public function __toString()
    {
        return $this->getTitle();
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
}