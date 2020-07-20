<?php

namespace App\Entity;

use App\Repository\PolicyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PolicyRepository::class)
 */
class Policy
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $source;

    /**
     * @ORM\ManyToOne(targetEntity=PolicyTheme::class, inversedBy="policies")
     */
    private $policyTheme;

    /**
     * @ORM\OneToOne(targetEntity=Argument::class, cascade={"persist", "remove"})
     */
    private $argument;

    /**
     * @ORM\ManyToOne(targetEntity=Language::class, inversedBy="policies")
     */
    private $language;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getPolicyTheme(): ?PolicyTheme
    {
        return $this->policyTheme;
    }

    public function setPolicyTheme(?PolicyTheme $policyTheme): self
    {
        $this->policyTheme = $policyTheme;

        return $this;
    }

    public function getArgument(): ?Argument
    {
        return $this->argument;
    }

    public function setArgument(?Argument $argument): self
    {
        $this->argument = $argument;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }
}
