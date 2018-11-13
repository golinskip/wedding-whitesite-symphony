<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParameterRepository")
 */
class Parameter
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getConfig(): ?string
    {
        return $this->config;
    }

    public function setConfig(?string $config): self
    {
        $this->config = $config;

        return $this;
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
}
