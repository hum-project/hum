<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity=Policy::class, mappedBy="vote")
     */
    private $policies;

    public function __construct()
    {
        $this->policies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Policy[]
     */
    public function getPolicies(): Collection
    {
        return $this->policies;
    }

    public function addPolicy(Policy $policy): self
    {
        if (!$this->policies->contains($policy)) {
            $this->policies[] = $policy;
            $policy->setVote($this);
        }

        return $this;
    }

    public function removePolicy(Policy $policy): self
    {
        if ($this->policies->contains($policy)) {
            $this->policies->removeElement($policy);
            // set the owning side to null (unless already changed)
            if ($policy->getVote() === $this) {
                $policy->setVote(null);
            }
        }

        return $this;
    }

    public function getRootPolicy()
    {
        $rootPolicy = null;
        foreach ($this->getPolicies() as $policy) {
            if (null === $policy->getParent()) {
                $rootPolicy = $policy;
                break;
            }
        }
        return $rootPolicy;
    }
}
