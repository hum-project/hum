<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\InstitutionRepository;
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
 * @ORM\Entity(repositoryClass=InstitutionRepository::class)
 */
class Institution
{
    /**
     * @Groups({"hum"})
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"hum"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Groups({"hum"})
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity=PolicyTheme::class, inversedBy="institutions")
     */
    private $policyTheme;

    /**
     * @Groups({"hum"})
     * @ORM\ManyToOne(targetEntity=Language::class, inversedBy="institutions")
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity=Institution::class, inversedBy="translations")
     */
    private $translation;

    /**
     * @Groups({"hum"})
     * @ORM\OneToMany(targetEntity=Institution::class, mappedBy="translation")
     */
    private $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getPolicyTheme(): ?PolicyTheme
    {
        return $this->policyTheme;
    }

    public function setPolicyTheme(?PolicyTheme $policyTheme): self
    {
        $this->policyTheme = $policyTheme;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getTranslation(): ?self
    {
        return $this->translation;
    }

    public function setTranslation(?self $translation): self
    {
        $this->translation = $translation;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function addTranslation(self $translation): self
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->setTranslation($this);
        }

        return $this;
    }

    public function removeTranslation(self $translation): self
    {
        if ($this->translations->contains($translation)) {
            $this->translations->removeElement($translation);
            // set the owning side to null (unless already changed)
            if ($translation->getTranslation() === $this) {
                $translation->setTranslation(null);
            }
        }

        return $this;
    }


}
