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

    /**
     * @ORM\OneToMany(targetEntity=ContinuousAnswer::class, mappedBy="question")
     */
    private $continuousAnswers;

    /**
     * @ORM\OneToMany(targetEntity=OrdinalAnswer::class, mappedBy="question")
     */
    private $ordinalAnswers;

    /**
     * @ORM\OneToMany(targetEntity=NominalAnswer::class, mappedBy="question")
     */
    private $nominalAnswers;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->continuousAnswers = new ArrayCollection();
        $this->ordinalAnswers = new ArrayCollection();
        $this->nominalAnswers = new ArrayCollection();
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

    /**
     * @return Collection|ContinuousAnswer[]
     */
    public function getContinuousAnswers(): Collection
    {
        return $this->continuousAnswers;
    }

    public function addContinuousAnswer(ContinuousAnswer $continuousAnswer): self
    {
        if (!$this->continuousAnswers->contains($continuousAnswer)) {
            $this->continuousAnswers[] = $continuousAnswer;
            $continuousAnswer->setQuestion($this);
        }

        return $this;
    }

    public function removeContinuousAnswer(ContinuousAnswer $continuousAnswer): self
    {
        if ($this->continuousAnswers->contains($continuousAnswer)) {
            $this->continuousAnswers->removeElement($continuousAnswer);
            // set the owning side to null (unless already changed)
            if ($continuousAnswer->getQuestion() === $this) {
                $continuousAnswer->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OrdinalAnswer[]
     */
    public function getOrdinalAnswers(): Collection
    {
        return $this->ordinalAnswers;
    }

    public function addOrdinalAnswer(OrdinalAnswer $ordinalAnswer): self
    {
        if (!$this->ordinalAnswers->contains($ordinalAnswer)) {
            $this->ordinalAnswers[] = $ordinalAnswer;
            $ordinalAnswer->setQuestion($this);
        }

        return $this;
    }

    public function removeOrdinalAnswer(OrdinalAnswer $ordinalAnswer): self
    {
        if ($this->ordinalAnswers->contains($ordinalAnswer)) {
            $this->ordinalAnswers->removeElement($ordinalAnswer);
            // set the owning side to null (unless already changed)
            if ($ordinalAnswer->getQuestion() === $this) {
                $ordinalAnswer->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|NominalAnswer[]
     */
    public function getNominalAnswers(): Collection
    {
        return $this->nominalAnswers;
    }

    public function addNominalAnswer(NominalAnswer $nominalAnswer): self
    {
        if (!$this->nominalAnswers->contains($nominalAnswer)) {
            $this->nominalAnswers[] = $nominalAnswer;
            $nominalAnswer->setQuestion($this);
        }

        return $this;
    }

    public function removeNominalAnswer(NominalAnswer $nominalAnswer): self
    {
        if ($this->nominalAnswers->contains($nominalAnswer)) {
            $this->nominalAnswers->removeElement($nominalAnswer);
            // set the owning side to null (unless already changed)
            if ($nominalAnswer->getQuestion() === $this) {
                $nominalAnswer->setQuestion(null);
            }
        }

        return $this;
    }

}
