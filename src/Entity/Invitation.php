<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use voku\helper\URLify;
use App\Helpers\ValueGenerator;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\InvitationRepository")
 */
class Invitation
{
    const STATUS_NEW = 1;
    const STATUS_VISITED = 2;
    const STATUS_PARTIALLY_CONFIRMED = 3;
    const STATUS_CONFIRMED_ALL_PRESENT = 4;
    const STATUS_CONFIRMED_PARTIALLY_PRESENT = 5;
    const STATUS_CONFIRMED_ALL_ABSENT = 6;

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=31, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="integer")
     */
    private $code;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     */
    private $last_change;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url_name;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $token;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Person", mappedBy="invitation", orphanRemoval=true, cascade={"persist"})
     */
    private $people;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\InvitationGroup", inversedBy="invitation")
     */
    private $invitationGroup;

    public function __construct()
    {
        $this->people = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCode(): self
    {
        $this->code = ValueGenerator::code();

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedValue(): self
    {
        $this->created = new \DateTime();

        return $this;
    }

    public function getLastChange(): ?\DateTimeInterface
    {
        return $this->last_change;
    }


    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function setLastChange(): self
    {
        $this->last_change = new \DateTime();

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
        $this->status = self::STATUS_NEW;

        return $this;
    }

    public function getUrlName(): ?string
    {
        return $this->url_name;
    }

    /**
     * @ORM\PrePersist
     */
    public function setUrlName(): self
    {
        $this->url_name = URLify::filter($this->getName());
        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }


    /**
     * @ORM\PrePersist
     */
    public function setToken(): self
    {
        $this->token = ValueGenerator::token();

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getPeople(): Collection
    {
        return $this->people;
    }

    public function addPerson(Person $person): self
    {
        if (!$this->people->contains($person)) {
            $this->people[] = $person;
            $person->setInvitation($this);
        }

        return $this;
    }

    public function removePerson(Person $person): self
    {
        if ($this->people->contains($person)) {
            $this->people->removeElement($person);
            // set the owning side to null (unless already changed)
            if ($person->getInvitation() === $this) {
                $person->setInvitation(null);
            }
        }

        return $this;
    }

    public function getInvitationGroup(): ?InvitationGroup
    {
        return $this->invitationGroup;
    }

    public function setInvitationGroup(?InvitationGroup $invitationGroup): self
    {
        $this->invitationGroup = $invitationGroup;

        return $this;
    }
}
