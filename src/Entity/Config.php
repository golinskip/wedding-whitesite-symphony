<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\ConfigRepository")
 */
class Config
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $form_type;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $form_options;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $config_group;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $value;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $default_value;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFormType(): ?string
    {
        return $this->form_type;
    }

    public function setFormType(string $form_type): self
    {
        $this->form_type = $form_type;

        return $this;
    }

    public function getConfigGroup(): ?string
    {
        return $this->config_group;
    }

    public function setConfigGroup(string $config_group): self
    {
        $this->config_group = $config_group;

        return $this;
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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function getDefaultValue(): ?string
    {
        return $this->default_value;
    }

    public function setDefaultValue(string $default_value): self
    {
        $this->default_value = $default_value;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFormOptions()
    {
        if($this->form_options == null) {
            return [];
        }
        return \json_decode($this->form_options, true);
    }

    public function setFormOptions($form_options): self
    {
        $this->form_options = \json_encode($form_options);

        return $this;
    }
}
