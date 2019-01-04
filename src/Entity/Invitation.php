<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use voku\helper\URLify;
use App\Helpers\ValueGenerator;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Person;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\InvitationRepository")
 */
class Invitation implements UserInterface
{

    const ROLE = 'ROLE_PRIVATE_ACCESS';
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ParameterValue", mappedBy="invitation", cascade={"persist"})
     */
    private $parameterValues;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Gift", mappedBy="invitation")
     */
    private $gifts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EventLog", mappedBy="invitation")
     */
    private $eventLog;

    public function __construct()
    {
        $this->people = new ArrayCollection();
        $this->parameterValues = new ArrayCollection();
        $this->gifts = new ArrayCollection();
        $this->eventLog = new ArrayCollection();
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

    public function setCode(?string $code): self
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function generateCode(): self
    {
        if(!$this->getCode()) {
            $this->code = ValueGenerator::code();
        }

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


    /**
     * Implements login by Invitation
     */
    public function getRoles() {
        return [self::ROLE];
    }

    public function getPassword() {
        return $this->code;
    }

    public function getSalt() {
        return null;
    }

    public function getUsername() {
        return $this->getUrlName();
    }

    public function eraseCredentials() {}

    public function __toString() {
        if($this->getName() === null) {
            return "New Invitation";
        }
        return $this->getName();
    }

    const ST_UNCONFIRMED = 0;
    const ST_ALL_PRES = 1;
    const ST_PART_PRES = 2;
    const ST_ALL_ABS = 3;
    /**
     * 0 - unconfirmed exists
     * 1 - all presents
     * 2 - partially presents
     * 3 - all absent
     *
     * @return void
     */
    public function getPartialStatus() {
        $ret = -1;
        foreach($this->getPeople() as $Person) {
            if($Person->getStatus() == Person::STATUS_UNDEFINED) {
                return self::ST_UNCONFIRMED;
            }
            if($ret == self::ST_PART_PRES) {
                continue;
            }
            if($ret == self::ST_ALL_PRES  && $Person->getStatus() == Person::STATUS_ABSENT || 
               $ret == self::ST_ALL_ABS && $Person->getStatus() == Person::STATUS_PRESENT ) {
                $ret = self::ST_PART_PRES;
            } else if($Person->getStatus() == Person::STATUS_ABSENT) {
                $ret = self::ST_ALL_ABS;
            } else {
                $ret = self::ST_ALL_PRES;
            }
        }
        return $ret;
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
            $parameterValue->setInvitation($this);
        }

        return $this;
    }

    public function removeParameterValue(ParameterValue $parameterValue): self
    {
        if ($this->parameterValues->contains($parameterValue)) {
            $this->parameterValues->removeElement($parameterValue);
            // set the owning side to null (unless already changed)
            if ($parameterValue->getInvitation() === $this) {
                $parameterValue->setInvitation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Gift[]
     */
    public function getGifts(): Collection
    {
        return $this->gifts;
    }

    public function addGift(Gift $gift): self
    {
        if (!$this->gifts->contains($gift)) {
            $this->gifts[] = $gift;
            $gift->setInvitation($this);
        }

        return $this;
    }

    public function removeGift(Gift $gift): self
    {
        if ($this->gifts->contains($gift)) {
            $this->gifts->removeElement($gift);
            // set the owning side to null (unless already changed)
            if ($gift->getInvitation() === $this) {
                $gift->setInvitation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EventLog[]
     */
    public function getEventLog(): Collection
    {
        return $this->eventLog;
    }

    public function addEventLog(EventLog $eventLog): self
    {
        if (!$this->eventLog->contains($eventLog)) {
            $this->eventLog[] = $eventLog;
            $eventLog->setInvitation($this);
        }

        return $this;
    }

    public function removeEventLog(EventLog $eventLog): self
    {
        if ($this->eventLog->contains($eventLog)) {
            $this->eventLog->removeElement($eventLog);
            // set the owning side to null (unless already changed)
            if ($eventLog->getInvitation() === $this) {
                $eventLog->setInvitation(null);
            }
        }

        return $this;
    }
}
