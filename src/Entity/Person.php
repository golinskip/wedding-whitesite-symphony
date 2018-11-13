<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 */
class Person
{

    const STATUS_UNDEFINED = 0;
    const STATUS_PRESENT = 1;
    const STATUS_ABSENT = 2;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Invitation", inversedBy="people", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $invitation;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;


    /**
     * @ORM\Column(type="boolean")
     */
    private $editable = false;

    /**
     * @ORM\Column(type="integer")
     */
    private $custom_order = 0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PersonGroup", inversedBy="person")
     */
    private $personGroup;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ParameterValue", mappedBy="person")
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

    public function getInvitation(): ?Invitation
    {
        return $this->invitation;
    }

    public function setInvitation(?Invitation $invitation): self
    {
        $this->invitation = $invitation;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }


    /**
     * @ORM\PrePersist
     */
    public function setStatus(): self
    {
        $this->status = self::STATUS_UNDEFINED;

        return $this;
    }
    
    public function getEditable(): ?bool
    {
        return $this->editable;
    }

    public function setEditable(bool $editable): self 
    {
        $this->editable = $editable;
        return $this;
    }

    public function getCustomOrder(): ?int
    {
        return $this->custom_order;
    }

    public function setCustomOrder(int $custom_order): self
    {
        $this->custom_order = $custom_order;

        return $this;
    }

    public function getPersonGroup(): ?PersonGroup
    {
        return $this->personGroup;
    }

    public function setPersonGroup(?PersonGroup $personGroup): self
    {
        $this->personGroup = $personGroup;

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
            $parameterValue->setPerson($this);
        }

        return $this;
    }

    public function removeParameterValue(ParameterValue $parameterValue): self
    {
        if ($this->parameterValues->contains($parameterValue)) {
            $this->parameterValues->removeElement($parameterValue);
            // set the owning side to null (unless already changed)
            if ($parameterValue->getPerson() === $this) {
                $parameterValue->setPerson(null);
            }
        }

        return $this;
    }
}
