<?php

namespace App\Entity;

use App\Repository\NominalAnswerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NominalAnswerRepository::class)
 */
class NominalAnswer
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
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="nominalAnswers")
     */
    private $question;

    /**
     * @ORM\OneToMany(targetEntity=ClientNominalAnswer::class, mappedBy="nominalAnswer")
     */
    private $clientNominalAnswers;

    public function __construct()
    {
        $this->clientNominalAnswers = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

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
     * @return Collection|ClientNominalAnswer[]
     */
    public function getClientNominalAnswers(): Collection
    {
        return $this->clientNominalAnswers;
    }

    public function addClientNominalAnswer(ClientNominalAnswer $clientNominalAnswer): self
    {
        if (!$this->clientNominalAnswers->contains($clientNominalAnswer)) {
            $this->clientNominalAnswers[] = $clientNominalAnswer;
            $clientNominalAnswer->setNominalAnswer($this);
        }

        return $this;
    }

    public function removeClientNominalAnswer(ClientNominalAnswer $clientNominalAnswer): self
    {
        if ($this->clientNominalAnswers->contains($clientNominalAnswer)) {
            $this->clientNominalAnswers->removeElement($clientNominalAnswer);
            // set the owning side to null (unless already changed)
            if ($clientNominalAnswer->getNominalAnswer() === $this) {
                $clientNominalAnswer->setNominalAnswer(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return "Nominal type: " . $this->getValue();
    }


}
