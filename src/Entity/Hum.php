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
     * @ORM\OneToOne(targetEntity=Policy::class, cascade={"persist", "remove"})
     */
    private $policy;

    /**
     * @ORM\OneToOne(targetEntity=Institution::class, cascade={"persist", "remove"})
     */
    private $institution;


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

    public function getPolicy(): ?Policy
    {
        return $this->policy;
    }

    public function setPolicy(?Policy $policy): self
    {
        $this->policy = $policy;

        return $this;
    }

    public function getInstitution(): ?Institution
    {
        return $this->institution;
    }

    public function setInstitution(?Institution $institution): self
    {
        $this->institution = $institution;

        return $this;
    }

    public function __toString()
    {
        return $this->getPolicy() . ' [' . $this->getDate()->format("Y-m-d") . ']';
    }


}
