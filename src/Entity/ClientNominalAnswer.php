<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ClientNominalAnswerRepository;
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
