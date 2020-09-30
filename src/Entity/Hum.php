<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\HumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"hum"}},
 *     collectionOperations={
 *         "get"
 *     },
 *     itemOperations={
 *         "get"
 *     }
 * )
 * @ORM\Entity(repositoryClass=HumRepository::class)
 */
class Hum
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
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @Groups({"hum"})
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="hum")
     */
    private $questions;

    /**
     * @Groups({"hum"})
     * @ORM\OneToOne(targetEntity=Policy::class, cascade={"persist", "remove"})
     */
    private $policy;

    /**
     * @Groups({"hum"})
     * @ORM\OneToOne(targetEntity=Institution::class, cascade={"persist", "remove"})
     */
    private $institution;

    /**
     * @ORM\OneToMany(targetEntity=ClientAnswer::class, mappedBy="hum")
     */
    private $clientAnswers;


    public function __construct()
    {
        $this->date = new \DateTime('now');
        $this->date->modify('+7 day');
        $this->questions = new ArrayCollection();
        $this->hums = new ArrayCollection();
        $this->clientAnswers = new ArrayCollection();
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
            $clientAnswer->setHum($this);
        }

        return $this;
    }

    public function removeClientAnswer(ClientAnswer $clientAnswer): self
    {
        if ($this->clientAnswers->contains($clientAnswer)) {
            $this->clientAnswers->removeElement($clientAnswer);
            // set the owning side to null (unless already changed)
            if ($clientAnswer->getHum() === $this) {
                $clientAnswer->setHum(null);
            }
        }

        return $this;
    }


}
