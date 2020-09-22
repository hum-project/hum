<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ContinuousAnswerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     collectionOperations={
 *         "get"
 *     },
 *     itemOperations={
 *         "get"
 *     }
 * )
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
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="continuousAnswers")
     */
    private $question;

    /**
     * @ORM\OneToMany(targetEntity=ClientContinuousAnswer::class, mappedBy="continuousAnswer")
     */
    private $clientContinuousAnswers;

    /**
     * @ORM\Column(type="float")
     */
    private $minimum;

    /**
     * @ORM\Column(type="float")
     */
    private $maximum;

    public function __construct()
    {
        $this->clientContinuousAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMinimum(): ?float
    {
        return $this->minimum;
    }

    public function setMinimum(float $minimum): self
    {
        $this->minimum = $minimum;

        return $this;
    }

    public function getMaximum(): ?float
    {
        return $this->maximum;
    }

    public function setMaximum(float $maximum): self
    {
        $this->maximum = $maximum;

        return $this;
    }

    public function __toString()
    {
        return "Continuous type: " . $this->getMinimum() . " - " . $this->getMaximum();
    }
    
}
