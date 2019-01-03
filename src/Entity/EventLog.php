<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\EventLogRepository")
 */
class EventLog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $env;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tag;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Invitation", inversedBy="eventLog")
     */
    private $invitation;

    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     */
    private $userAgent;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $ip;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EventLogDetail", mappedBy="eventLog")
     */
    private $eventLogDetails;

    public function __construct()
    {
        $this->eventLogDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnv(): ?int
    {
        return $this->env;
    }

    public function setEnv(int $env): self
    {
        $this->env = $env;

        return $this;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    public function setUserAgent(?string $userAgent): self
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function autoDate(): self
    {
        $this->date = new \DateTime();

        return $this;
    }

    /**
     * @return Collection|EventLogDetail[]
     */
    public function getEventLogDetails(): Collection
    {
        return $this->eventLogDetails;
    }

    public function addEventLogDetail(EventLogDetail $eventLogDetail): self
    {
        if (!$this->eventLogDetails->contains($eventLogDetail)) {
            $this->eventLogDetails[] = $eventLogDetail;
            $eventLogDetail->setEventLog($this);
        }

        return $this;
    }

    public function removeEventLogDetail(EventLogDetail $eventLogDetail): self
    {
        if ($this->eventLogDetails->contains($eventLogDetail)) {
            $this->eventLogDetails->removeElement($eventLogDetail);
            // set the owning side to null (unless already changed)
            if ($eventLogDetail->getEventLog() === $this) {
                $eventLogDetail->setEventLog(null);
            }
        }

        return $this;
    }
}
