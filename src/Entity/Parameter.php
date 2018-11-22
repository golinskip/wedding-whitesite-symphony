<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Model\ParameterType\Logic;
use App\Model\ParameterType\Text;
use App\Model\ParameterType\Enum;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\ParameterRepository")
 */
class Parameter
{
    const TYPE_LOGIC = 'logic';
    const TYPE_TEXT = 'text';
    const TYPE_ENUM = 'enum';
    
    public static $typeList = [
        self::TYPE_LOGIC => Logic::class,
        self::TYPE_TEXT => Text::class,
        self::TYPE_ENUM => Enum::class,
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
    private $name;


    /**
     * @ORM\Column(type="boolean")
     */
    private $visible;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $type;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $config;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ParameterValue", mappedBy="parameter")
     */
    private $parameterValues;

    public function __construct()
    {
        $this->parameterValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;
        return $this;
    }

    public function getConfig()
    {
        if($this->config === null) {
            $configClass = $this->getConfigClass();
            $this->config = new $configClass;
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
    public function setEmptyConfig() {

        $type = $this->getType();
        $emptyConfig = new self::$typeList[$type];
        $this->setConfig($emptyConfig);
    }

    /**
     * @return Collection|ParameterValue[]
     */
    public function getParameterValues(): Collection
    {
        return $this->parameterValues;
    }

    public function addParameterValue(ParameterValue $parameterValue): self
    {
        if (!$this->parameterValues->contains($parameterValue)) {
            $this->parameterValues[] = $parameterValue;
            $parameterValue->setParameter($this);
        }

        return $this;
    }

    public function removeParameterValue(ParameterValue $parameterValue): self
    {
        if ($this->parameterValues->contains($parameterValue)) {
            $this->parameterValues->removeElement($parameterValue);
            // set the owning side to null (unless already changed)
            if ($parameterValue->getParameter() === $this) {
                $parameterValue->setParameter(null);
            }
        }

        return $this;
    }

    public function getConfigClass() {
        return "App\\Model\\ParameterType\\".ucfirst($Parameter->getType());
    }


    public function __toString() {
        return $this->getName();
    }
}
