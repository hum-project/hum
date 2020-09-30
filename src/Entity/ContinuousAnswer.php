<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ContinuousAnswerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @Groups({"hum"})
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
     * @Groups({"hum"})
     * @ORM\Column(type="float")
     */
    private $minimum;

    /**
     * @Groups({"hum"})
     * @ORM\Column(type="float")
     */
    private $maximum;

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
