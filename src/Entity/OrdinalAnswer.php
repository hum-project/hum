<?php

namespace App\Entity;

use App\Repository\OrdinalAnswerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrdinalAnswerRepository::class)
 */
class OrdinalAnswer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $value;

    /**
     * @ORM\Column(type="integer")
     */
    private $scale;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="ordinalAnswers")
     */
    private $question;

    /**
     * @ORM\OneToMany(targetEntity=ClientOrdinalAnswer::class, mappedBy="ordinalAnswer")
     */
    private $clientOrdinalAnswers;


    public function __construct()
    {
        $this->setScale(5);
        $this->clientOrdinalAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        if ($value <= $this->getScale() && $value > 0) {
            $this->value = $value;
        }

        return $this;
    }

    public function getScale(): ?int
    {
        return $this->scale;
    }

    public function setScale(int $scale): self
    {
        $this->scale = $scale;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    /**
     * @return Collection|ClientOrdinalAnswer[]
     */
    public function getClientOrdinalAnswers(): Collection
    {
        return $this->clientOrdinalAnswers;
    }

    public function addClientOrdinalAnswer(ClientOrdinalAnswer $clientOrdinalAnswer): self
    {
        if (!$this->clientOrdinalAnswers->contains($clientOrdinalAnswer)) {
            $this->clientOrdinalAnswers[] = $clientOrdinalAnswer;
            $clientOrdinalAnswer->setOrdinalAnswer($this);
        }

        return $this;
    }

    public function removeClientOrdinalAnswer(ClientOrdinalAnswer $clientOrdinalAnswer): self
    {
        if ($this->clientOrdinalAnswers->contains($clientOrdinalAnswer)) {
            $this->clientOrdinalAnswers->removeElement($clientOrdinalAnswer);
            // set the owning side to null (unless already changed)
            if ($clientOrdinalAnswer->getOrdinalAnswer() === $this) {
                $clientOrdinalAnswer->setOrdinalAnswer(null);
            }
        }

        return $this;
    }

}
