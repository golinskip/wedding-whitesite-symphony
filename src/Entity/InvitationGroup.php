<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvitationGroupRepository")
 */
class InvitationGroup
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
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $color;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Invitation", mappedBy="invitationGroup")
     */
    private $invitation;

    /**
     * @ORM\Column(type="integer")
     */
    private $custom_order = 0;

    public function __construct()
    {
        $this->invitation = new ArrayCollection();
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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection|Invitation[]
     */
    public function getInvitation(): Collection
    {
        return $this->invitation;
    }

    public function addInvitation(Invitation $invitation): self
    {
        if (!$this->invitation->contains($invitation)) {
            $this->invitation[] = $invitation;
            $invitation->setInvitationGroup($this);
        }

        return $this;
    }

    public function removeInvitation(Invitation $invitation): self
    {
        if ($this->invitation->contains($invitation)) {
            $this->invitation->removeElement($invitation);
            // set the owning side to null (unless already changed)
            if ($invitation->getInvitationGroup() === $this) {
                $invitation->setInvitationGroup(null);
            }
        }

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

    public function __toString() {
        return $this->getName();
    }
}
