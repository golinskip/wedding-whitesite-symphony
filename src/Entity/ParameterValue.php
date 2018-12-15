<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParameterValueRepository")
 */
class ParameterValue
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parameter", inversedBy="parameterValues")
     */
    private $parameter;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person", inversedBy="parameterValues")
     * @ORM\JoinColumn(nullable=true)
     */
    private $person;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Invitation", inversedBy="parameterValues")
     * @ORM\JoinColumn(nullable=true)
     */
    private $invitation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getParameter(): ?Parameter
    {
        return $this->parameter;
    }

    public function setParameter(?Parameter $parameter): self
    {
        $this->parameter = $parameter;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue($value): self
    {
        $this->value = $value;

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
}
