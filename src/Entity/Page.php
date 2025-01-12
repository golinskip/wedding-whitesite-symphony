<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use voku\helper\URLify;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 */
class Page
{
    const SITE_PUBLIC = 0;
    const SITE_PRIVATE = 1;
    


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Page", mappedBy="parent")
     */
    //private $children;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Page", inversedBy="children")
     * @ORM\JoinColumn(name="p_id", referencedColumnName="id")
     */
    //private $parent;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url_name;

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
     * @ORM\Column(type="boolean")
     */
    private $is_root;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PageBlock", mappedBy="page", cascade={"remove"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $page_block;

    
    /**
     * @ORM\Column(type="boolean")
     */
    private $is_public;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $is_in_menu;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->created_by = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /*public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     *
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->child[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->contains($child)) {
            $this->children->removeElement($child);
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->getParent(null);
            }
        }

        return $this;
    }*/

    public function getSite(): ?int
    {
        return $this->site;
    }

    public function setSite(int $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getTitleExt(): ?string
    {
        if($this->getIsRoot()) {
            if($this->getIsPublic()) {
                return $this->title." (Public Root)";
            } else {
                return $this->title." (Private Root)";
            }
        }
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUrlName(): ?string
    {
        return $this->url_name;
    }

    public function setUrlName(string $url_name): self
    {
        $this->url_name = $url_name;

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

    public function setStartPublishAt(?\DateTimeInterface $start_publish_at): self
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

    public function getIsRoot(): ?bool
    {
        return $this->is_root;
    }

    public function setIsRoot(bool $is_root): self
    {
        $this->is_root = $is_root;

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
     * @return Collection|PageBlock[]
     */
    public function getPageBlocks(): Collection
    {
        return $this->page_block;
    }

    public function addPageBlock(PageBlock $page_block): self
    {
        if (!$this->page_block->contains($page_block)) {
            $this->page_block[] = $page_block;
            $page_block->setBlocks($this);
        }

        return $this;
    }

    public function removePageBlock(PageBlock $page_block): self
    {
        if ($this->page_block->contains($page_block)) {
            $this->page_block->removeElement($page_block);
            // set the owning side to null (unless already changed)
            if ($page_block->getBlocks() === $this) {
                $page_block->setBlocks(null);
            }
        }

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
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function autoUpdatedAt(): self
    {
        $this->updated_at = new \DateTime();

        return $this;
    }


    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function autoUrlName(): self
    {
        $this->url_name = URLify::filter($this->getTitle());
        return $this;
    }

    public function __toString() {
        if($this->getTitle() === null) {
            return "New Page";
        }
        return $this->getTitle();
    }

    /**
     * Get the value of is_public
     */ 
    public function getIsPublic():?bool
    {
        return $this->is_public;
    }

    /**
     * Set the value of is_public
     *
     * @return  self
     */ 
    public function setIsPublic($is_public)
    {
        $this->is_public = $is_public;

        return $this;
    }

    /**
     * Get the value of is_in_menu
     */ 
    public function getIsInMenu():?bool
    {
        return $this->is_in_menu;
    }

    /**
     * Set the value of is_in_menu
     *
     * @return  self
     */ 
    public function setIsInMenu($is_in_menu)
    {
        $this->is_in_menu = $is_in_menu;

        return $this;
    }
}
