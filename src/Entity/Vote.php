<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VoteRepository::class)
 */
class Vote
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Policy::class, cascade={"persist", "remove"})
     */
    private $policy;

    /**
     * @ORM\Column(type="integer")
     */
    private $yes;

    /**
     * @ORM\Column(type="integer")
     */
    private $no;

    /**
     * @ORM\Column(type="integer")
     */
    private $abstain;

    /**
     * @ORM\Column(type="integer")
     */
    private $absent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPolicy(): ?Policy
    {
        return $this->policy;
    }

    public function setPolicy(?Policy $policy): self
    {
        $this->policy = $policy;

        return $this;
    }

    public function getYes(): ?int
    {
        return $this->yes;
    }

    public function setYes(int $yes): self
    {
        $this->yes = $yes;

        return $this;
    }

    public function getNo(): ?int
    {
        return $this->no;
    }

    public function setNo(int $no): self
    {
        $this->no = $no;

        return $this;
    }

    public function getAbstain(): ?int
    {
        return $this->abstain;
    }

    public function setAbstain(int $abstain): self
    {
        $this->abstain = $abstain;

        return $this;
    }

    public function getAbsent(): ?int
    {
        return $this->absent;
    }

    public function setAbsent(int $absent): self
    {
        $this->absent = $absent;

        return $this;
    }
}
