<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Entity\Page;
use voku\helper\URLify;
use App\Application\Sonata\MediaBundle\Entity\Media;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\PageBlockRepository")
 */
class PageBlock
{

    const STYLE_TINY = 0;
    const STYLE_FULL_BG_TINY = 1;
    const STYLE_FULL = 2;

    protected static $sizes = ['0', '5px', '10px','20px','30px', '40px','50px','60px','80px','100px','10vm','20vm','30vm','40vm'];
    protected static $bg_positions = [
        'Top' => 'top center',
        'Center' => 'center center',
        'Bottom' => 'bottom center',
    ];

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
     * @ORM\Column(type="string", length=255)
     */
    private $url_name;

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
     * @ORM\Column(type="text", nullable=true)
     */
    private $config;

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

    
    /**
     * @ORM\ManyToOne(targetEntity="App\Application\Sonata\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(nullable=true)
     */
    private $bg_image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bg_color;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $block_style;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $bg_position;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $margin_top;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $margin_bottom;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_full_height;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_in_menu;

    public static function getStyles() {
        return [
            'With margin' => self::STYLE_TINY,
            'Margin with full width' => self::STYLE_FULL_BG_TINY,
            'Full width' => self::STYLE_FULL,
        ];
    }

    public static function getSizes() {
        $sizes = [];
        foreach(self::$sizes as $size) {
            $sizes[$size] = $size;
        }
        return $sizes;
    }

    public static function getBgPositions() {
        return self::$bg_positions;
    }


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

    public function getBgColor(): ?string
    {
        return $this->bg_color;
    }

    public function setBgColor(?string $bg_color): self
    {
        $this->bg_color = $bg_color;

        return $this;
    }

    public function getBlockStyle(): ?int
    {
        return $this->block_style;
    }

    public function setBlockStyle(int $block_style): self
    {
        $this->block_style = $block_style;

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
     * @return Media
     */
    public function getBgImage()
    {
        return $this->bg_image;
    }

    /**
     * @param Media $media
     */
    public function setBgImage(?Media $bg_image)
    {
        $this->bg_image = $bg_image;
    }

    public function getConfig()
    {
        if($this->config === null) {
            return null;
        }

        return \unserialize($this->config);
    }

    public function setConfig($config): self
    {
        $this->config = \serialize($config);

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


    /**
     * Get the value of bg_position
     */ 
    public function getBgPosition()
    {
        return $this->bg_position;
    }

    /**
     * Set the value of bg_position
     *
     * @return  self
     */ 
    public function setBgPosition($bg_position)
    {
        $this->bg_position = $bg_position;

        return $this;
    }

    /**
     * Get the value of margin_top
     */ 
    public function getMarginTop()
    {
        return $this->margin_top;
    }

    /**
     * Set the value of margin_top
     *
     * @return  self
     */ 
    public function setMarginTop($margin_top)
    {
        $this->margin_top = $margin_top;

        return $this;
    }

    /**
     * Get the value of margin_bottom
     */ 
    public function getMarginBottom()
    {
        return $this->margin_bottom;
    }

    /**
     * Set the value of margin_bottom
     *
     * @return  self
     */ 
    public function setMarginBottom($margin_bottom)
    {
        $this->margin_bottom = $margin_bottom;

        return $this;
    }

    /**
     * Get the value of is_full_height
     */ 
    public function getIsFullHeight()
    {
        return $this->is_full_height;
    }

    /**
     * Set the value of is_full_height
     *
     * @return  self
     */ 
    public function setIsFullHeight($is_full_height)
    {
        $this->is_full_height = $is_full_height;

        return $this;
    }

    private $_currentTime = null;
    private function getCurrentTime() {
        if($this->_currentTime === null) {
            $this->_currentTime = \time();
        }
        return $this->_currentTime;
    }


    public function getShowable() {
        if(!$this->getIsEnabled()) {
            return false;
        }
        if($this->getStartPublishAt() !== null &&
            $this->getStartPublishAt()->getTimestamp() > $this->getCurrentTime()) {
            return false;
        }
        if($this->getStopPublishAt() !== null &&
            $this->getStopPublishAt()->getTimestamp() < $this->getCurrentTime()) {
            return false;
        }

        return true;
    }

    public function __toString() {
        if($this->getTitle() === null) {
            return "New Page Block";
        }
        return $this->getTitle();
    }

    /**
     * Get the value of is_in_menu
     */ 
    public function getIsInMenu()
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

    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function autoUrlName(): self
    {
        $this->url_name = URLify::filter($this->getTitle());
        return $this;
    }

    /**
     * Get the value of url_name
     */ 
    public function getUrlName()
    {
        return $this->url_name;
    }
}
