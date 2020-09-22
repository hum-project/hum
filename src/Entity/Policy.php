<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PolicyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     collectionOperations={
 *         "get"
 *     },
 *     itemOperations={
 *         "get"
 *     }
 * )
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

    /**
     * @ORM\ManyToOne(targetEntity=Policy::class, inversedBy="policies")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Policy::class, mappedBy="parent")
     */
    private $policies;

    /**
     * @ORM\ManyToOne(targetEntity=Vote::class, inversedBy="policies")
     */
    private $vote;

    public function __construct()
    {
        $this->policies = new ArrayCollection();
    }

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

    public function __toString()
    {
        return $this->getTitle();
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getPolicies(): Collection
    {
        return $this->policies;
    }

    public function addPolicy(self $policy): self
    {
        if (!$this->policies->contains($policy)) {
            $this->policies[] = $policy;
            $policy->setParent($this);
        }

        return $this;
    }

    public function removePolicy(self $policy): self
    {
        if ($this->policies->contains($policy)) {
            $this->policies->removeElement($policy);
            // set the owning side to null (unless already changed)
            if ($policy->getParent() === $this) {
                $policy->setParent(null);
            }
        }

        return $this;
    }

    public function getVote(): ?Vote
    {
        return $this->vote;
    }

    public function setVote(?Vote $vote): self
    {
        $this->vote = $vote;

        return $this;
    }


}
