<?php

namespace Hexmedia\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Slider
 *
 * @ORM\Table(name="slider")
 * @ORM\Entity(repositoryClass="Hexmedia\ContentBundle\Repository\Doctrine\SliderRepository")
 */
class Slider
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
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
     * @ORM\OneToMany(targetEntity="Hexmedia\ContentBundle\Entity\Slide", mappedBy="slider")
     */
    private $slides;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->slides = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Slider
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
     * @return Slider
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
     * @return Slider
     */
    public function setPublishedTo($publishedTo)
    {
        $this->publishedTo = $publishedTo;

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Slider
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Slider
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

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
     * Set sort
     *
     * @param integer $sort
     * @return Slider
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Add slides
     *
     * @param \Hexmedia\ContentBundle\Entity\Slide $slides
     * @return Slider
     */
    public function addSlide(\Hexmedia\ContentBundle\Entity\Slide $slides)
    {
        $this->slides[] = $slides;

        return $this;
    }

    /**
     * Remove slides
     *
     * @param \Hexmedia\ContentBundle\Entity\Slide $slides
     */
    public function removeSlide(\Hexmedia\ContentBundle\Entity\Slide $slides)
    {
        $this->slides->removeElement($slides);
    }

    /**
     * Get slides
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSlides()
    {
        return $this->slides;
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
     * Set name
     *
     * @param string $name
     * @return Slider
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


}