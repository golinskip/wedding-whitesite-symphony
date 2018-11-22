<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Entity\Page;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\PageBlockRepository")
 */
class PageBlock
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="App\Entity\Page", inversedBy="page_block")
     */
    private $page;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="json")
     */
    private $parameter = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $start_publish_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $stop_publish_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_enabled;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer")
     */
    private $position;


    public function __construct()
    {
        $this->created_by = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getParameter(): ?array
    {
        return $this->parameter;
    }

    public function setParameter(array $parameter): self
    {
        $this->parameter = $parameter;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getStartPublishAt(): ?\DateTimeInterface
    {
        return $this->start_publish_at;
    }

    public function setStartPublishAt(\DateTimeInterface $start_publish_at): self
    {
        $this->start_publish_at = $start_publish_at;

        return $this;
    }

    public function getStopPublishAt(): ?\DateTimeInterface
    {
        return $this->stop_publish_at;
    }

    public function setStopPublishAt(?\DateTimeInterface $stop_publish_at): self
    {
        $this->stop_publish_at = $stop_publish_at;

        return $this;
    }

    public function getIsEnabled(): ?bool
    {
        return $this->is_enabled;
    }

    public function setIsEnabled(bool $is_enabled): self
    {
        $this->is_enabled = $is_enabled;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function autoCreatedAt(): self
    {
        $this->created_at = new \DateTime();

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function autoEnabled(): self
    {
        $this->is_enabled = false;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function autoPosition(): self
    {
        $this->position = 0;

        return $this;
    }

    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function autoUpdatedAt(): self
    {
        $this->updated_at = new \DateTime();

        return $this;
    }

    public function __toString() {
        return (string)$this->getTitle();
    }
}
