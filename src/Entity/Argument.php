<?php

namespace App\Entity;

use App\Repository\ArgumentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArgumentRepository::class)
 */
class Argument
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $side;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\OneToOne(targetEntity=Argument::class, inversedBy="child", cascade={"persist", "remove"})
     */
    private $parent;

    /**
     * @ORM\OneToOne(targetEntity=Argument::class, mappedBy="parent", cascade={"persist", "remove"})
     */
    private $child;

    /**
     * @ORM\ManyToOne(targetEntity=Language::class, inversedBy="arguments")
     */
    private $language;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSide(): ?string
    {
        return $this->side;
    }

    public function setSide(string $side): self
    {
        $this->side = $side;

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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getChild(): ?self
    {
        return $this->child;
    }

    public function setChild(?self $child): self
    {
        $this->child = $child;

        return $this;
    }

    public function getDescendants()
    {
        $result = null;
        if (null !== $this->getChild()) {
            $array = array();
            $array[] = $this->getChild();
            $result = Argument::traverseDescendants($array, $this->getChild());
        }
        return $result;
    }

    public static function traverseDescendants($array, Argument $decendant)
    {
        $child = $decendant->getChild();
        if (null === $child) {
            return $array;
        }

        array_push($array, $child);
        return Argument::traverseDescendants($array, $child);

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
        return $this->getSide() . ': ' . substr($this->getText(), 0, 40);
    }
}
