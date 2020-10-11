<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ClientAnswerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ClientAnswerRepository::class)
 */
class ClientAnswer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Hum::class, inversedBy="clientAnswers")
     */
    private $hum;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $idHash;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="clientAnswers")
     */
    private $question;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $answer;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdHash(): ?string
    {
        return $this->idHash;
    }

    public function setIdHash(?string $idHash): self
    {
        $this->idHash = $idHash;

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

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

}
