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

    public function __construct()
    {
        $this->hums = new ArrayCollection();
        $this->blogPosts = new ArrayCollection();
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
}
