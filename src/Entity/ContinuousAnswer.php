<?php

namespace App\Entity;

use App\Repository\ContinuousAnswerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContinuousAnswerRepository::class)
 */
class ContinuousAnswer
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
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="continuousAnswers")
     */
    private $question;

    /**
     * @ORM\OneToMany(targetEntity=ClientContinuousAnswer::class, mappedBy="continuousAnswer")
     */
    private $clientContinuousAnswers;

    public function __construct()
    {
        $this->clientContinuousAnswers = new ArrayCollection();
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
     * @return Collection|ClientContinuousAnswer[]
     */
    public function getClientContinuousAnswers(): Collection
    {
        return $this->clientContinuousAnswers;
    }

    public function addClientContinuousAnswer(ClientContinuousAnswer $clientContinuousAnswer): self
    {
        if (!$this->clientContinuousAnswers->contains($clientContinuousAnswer)) {
            $this->clientContinuousAnswers[] = $clientContinuousAnswer;
            $clientContinuousAnswer->setContinuousAnswer($this);
        }

        return $this;
    }

    public function removeClientContinuousAnswer(ClientContinuousAnswer $clientContinuousAnswer): self
    {
        if ($this->clientContinuousAnswers->contains($clientContinuousAnswer)) {
            $this->clientContinuousAnswers->removeElement($clientContinuousAnswer);
            // set the owning side to null (unless already changed)
            if ($clientContinuousAnswer->getContinuousAnswer() === $this) {
                $clientContinuousAnswer->setContinuousAnswer(null);
            }
        }

        return $this;
    }
    
}
