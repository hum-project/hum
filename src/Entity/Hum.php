<?php

namespace App\Entity;

use App\Repository\HumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HumRepository::class)
 */
class Hum
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="hum")
     */
    private $questions;

    /**
     * @ORM\ManyToOne(targetEntity=Language::class, inversedBy="hums")
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity=Hum::class, inversedBy="hums")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Hum::class, mappedBy="parent")
     */
    private $hums;


    public function __construct()
    {
        $this->date = new \DateTime('now');
        $this->date->modify('+7 day');
        $this->questions = new ArrayCollection();
        $this->hums = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setHum($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getHum() === $this) {
                $question->setHum(null);
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
    public function getHums(): Collection
    {
        return $this->hums;
    }

    public function addHum(self $hum): self
    {
        if (!$this->hums->contains($hum)) {
            $this->hums[] = $hum;
            $hum->setParent($this);
        }

        return $this;
    }

    public function removeHum(self $hum): self
    {
        if ($this->hums->contains($hum)) {
            $this->hums->removeElement($hum);
            // set the owning side to null (unless already changed)
            if ($hum->getParent() === $this) {
                $hum->setParent(null);
            }
        }

        return $this;
    }
    
}
