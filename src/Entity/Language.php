<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LanguageRepository::class)
 */
class Language
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
     * @ORM\OneToMany(targetEntity=Hum::class, mappedBy="language")
     */
    private $hums;

    /**
     * @ORM\OneToMany(targetEntity=BlogPost::class, mappedBy="language")
     */
    private $blogPosts;

    /**
     * @ORM\OneToMany(targetEntity=PolicyTheme::class, mappedBy="language")
     */
    private $policyThemes;

    /**
     * @ORM\OneToMany(targetEntity=Institution::class, mappedBy="language")
     */
    private $institutions;

    public function __construct()
    {
        $this->hums = new ArrayCollection();
        $this->blogPosts = new ArrayCollection();
        $this->policyThemes = new ArrayCollection();
        $this->institutions = new ArrayCollection();
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

    /**
     * @return Collection|Hum[]
     */
    public function getHums(): Collection
    {
        return $this->hums;
    }

    public function addHum(Hum $hum): self
    {
        if (!$this->hums->contains($hum)) {
            $this->hums[] = $hum;
            $hum->setLanguage($this);
        }

        return $this;
    }

    public function removeHum(Hum $hum): self
    {
        if ($this->hums->contains($hum)) {
            $this->hums->removeElement($hum);
            // set the owning side to null (unless already changed)
            if ($hum->getLanguage() === $this) {
                $hum->setLanguage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BlogPost[]
     */
    public function getBlogPosts(): Collection
    {
        return $this->blogPosts;
    }

    public function addBlogPost(BlogPost $blogPost): self
    {
        if (!$this->blogPosts->contains($blogPost)) {
            $this->blogPosts[] = $blogPost;
            $blogPost->setLanguage($this);
        }

        return $this;
    }

    public function removeBlogPost(BlogPost $blogPost): self
    {
        if ($this->blogPosts->contains($blogPost)) {
            $this->blogPosts->removeElement($blogPost);
            // set the owning side to null (unless already changed)
            if ($blogPost->getLanguage() === $this) {
                $blogPost->setLanguage(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return Collection|PolicyTheme[]
     */
    public function getPolicyThemes(): Collection
    {
        return $this->policyThemes;
    }

    public function addPolicyTheme(PolicyTheme $policyTheme): self
    {
        if (!$this->policyThemes->contains($policyTheme)) {
            $this->policyThemes[] = $policyTheme;
            $policyTheme->setLanguage($this);
        }

        return $this;
    }

    public function removePolicyTheme(PolicyTheme $policyTheme): self
    {
        if ($this->policyThemes->contains($policyTheme)) {
            $this->policyThemes->removeElement($policyTheme);
            // set the owning side to null (unless already changed)
            if ($policyTheme->getLanguage() === $this) {
                $policyTheme->setLanguage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Institution[]
     */
    public function getInstitutions(): Collection
    {
        return $this->institutions;
    }

    public function addInstitution(Institution $institution): self
    {
        if (!$this->institutions->contains($institution)) {
            $this->institutions[] = $institution;
            $institution->setLanguage($this);
        }

        return $this;
    }

    public function removeInstitution(Institution $institution): self
    {
        if ($this->institutions->contains($institution)) {
            $this->institutions->removeElement($institution);
            // set the owning side to null (unless already changed)
            if ($institution->getLanguage() === $this) {
                $institution->setLanguage(null);
            }
        }

        return $this;
    }
}
