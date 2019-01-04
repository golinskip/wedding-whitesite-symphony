<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventLogDetailRepository")
 */
class EventLogDetail
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
    private $variable;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EventLog", inversedBy="eventLogDetails")
     */
    private $eventLog;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVariable(): ?string
    {
        return $this->variable;
    }

    public function setVariable(string $variable): self
    {
        $this->variable = $variable;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getEventLog(): ?EventLog
    {
        return $this->eventLog;
    }

    public function setEventLog(?EventLog $eventLog): self
    {
        $this->eventLog = $eventLog;

        return $this;
    }
}
