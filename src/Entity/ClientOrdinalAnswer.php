<?php

namespace App\Entity;

use App\Repository\ClientOrdinalAnswerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientOrdinalAnswerRepository::class)
 */
class ClientOrdinalAnswer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=OrdinalAnswer::class, inversedBy="clientOrdinalAnswers")
     */
    private $ordinalAnswer;

    /**
     * @ORM\Column(type="integer")
     */
    private $value;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrdinalAnswer(): ?OrdinalAnswer
    {
        return $this->ordinalAnswer;
    }

    public function setOrdinalAnswer(?OrdinalAnswer $ordinalAnswer): self
    {
        $this->ordinalAnswer = $ordinalAnswer;

        return $this;
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
}
