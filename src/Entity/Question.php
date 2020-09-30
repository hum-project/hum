<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={
 *         "get"
 *     },
 *     itemOperations={
 *         "get"
 *     }
 * )
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{
    /**
     * @Groups({"hum"})
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"hum"})
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
     * @Groups({"hum"})
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="translation")
     */
    private $translations;

    /**
     * @Groups({"hum"})
     * @ORM\ManyToOne(targetEntity=Language::class, inversedBy="questions")
     */
    private $language;

    /**
     * @Groups({"hum"})
     * @ORM\OneToMany(targetEntity=ContinuousAnswer::class, mappedBy="question")
     */
    private $continuousAnswers;

    /**
     * @Groups({"hum"})
     * @ORM\OneToMany(targetEntity=OrdinalAnswer::class, mappedBy="question")
     */
    private $ordinalAnswers;

    /**
     * @Groups({"hum"})
     * @ORM\OneToMany(targetEntity=NominalAnswer::class, mappedBy="question")
     */
    private $nominalAnswers;

    /**
     * @ORM\OneToMany(targetEntity=ClientAnswer::class, mappedBy="question")
     */
    private $clientAnswers;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->continuousAnswers = new ArrayCollection();
        $this->ordinalAnswers = new ArrayCollection();
        $this->nominalAnswers = new ArrayCollection();
        $this->clientAnswers = new ArrayCollection();
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
        return $this->getText();
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

    /**
     * @return Collection|ClientAnswer[]
     */
    public function getClientAnswers(): Collection
    {
        return $this->clientAnswers;
    }

    public function addClientAnswer(ClientAnswer $clientAnswer): self
    {
        if (!$this->clientAnswers->contains($clientAnswer)) {
            $this->clientAnswers[] = $clientAnswer;
            $clientAnswer->setQuestion($this);
        }

        return $this;
    }

    public function removeClientAnswer(ClientAnswer $clientAnswer): self
    {
        if ($this->clientAnswers->contains($clientAnswer)) {
            $this->clientAnswers->removeElement($clientAnswer);
            // set the owning side to null (unless already changed)
            if ($clientAnswer->getQuestion() === $this) {
                $clientAnswer->setQuestion(null);
            }
        }

        return $this;
    }

}
