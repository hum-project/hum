<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ClientContinuousAnswerRepository;
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
 * @ORM\Entity(repositoryClass=ClientContinuousAnswerRepository::class)
 */
class ClientContinuousAnswer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ContinuousAnswer::class, inversedBy="clientContinuousAnswers")
     */
    private $continuousAnswer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContinuousAnswer(): ?ContinuousAnswer
    {
        return $this->continuousAnswer;
    }

    public function setContinuousAnswer(?ContinuousAnswer $continuousAnswer): self
    {
        $this->continuousAnswer = $continuousAnswer;

        return $this;
    }

}
