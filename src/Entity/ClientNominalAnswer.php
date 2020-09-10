<?php

namespace App\Entity;

use App\Repository\ClientNominalAnswerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientNominalAnswerRepository::class)
 */
class ClientNominalAnswer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=NominalAnswer::class, inversedBy="clientNominalAnswers")
     */
    private $nominalAnswer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNominalAnswer(): ?NominalAnswer
    {
        return $this->nominalAnswer;
    }

    public function setNominalAnswer(?NominalAnswer $nominalAnswer): self
    {
        $this->nominalAnswer = $nominalAnswer;

        return $this;
    }
}
