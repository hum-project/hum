<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity=Hum::class, inversedBy="questions")
     */
    private $hum;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="translations")
     */
    private $translation;

    /**
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="translation")
     */
    private $translations;

    /**
     * @ORM\ManyToOne(targetEntity=Language::class, inversedBy="questions")
     */
    private $language;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getHum(): ?Hum
    {
        return $this->hum;
    }

    public function setHum(?Hum $hum): self
    {
        $this->hum = $hum;

        return $this;
    }

    public function __toString()
    {
        return substr($this->getText(), 0, 40);
    }

    public function getTranslation(): ?self
    {
        return $this->translation;
    }

    public function setTranslation(?self $translation): self
    {
        $this->translation = $translation;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function addTranslation(self $translation): self
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->setTranslation($this);
        }

        return $this;
    }

    public function removeTranslation(self $translation): self
    {
        if ($this->translations->contains($translation)) {
            $this->translations->removeElement($translation);
            // set the owning side to null (unless already changed)
            if ($translation->getTranslation() === $this) {
                $translation->setTranslation(null);
            }
        }

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
