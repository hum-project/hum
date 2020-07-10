<?php

namespace App\Entity;

use App\Repository\BlogImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogImageRepository::class)
 */
class BlogImage
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
    private $ordering;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $subtext;

    /**
     * @ORM\OneToOne(targetEntity=Image::class, cascade={"persist", "remove"})
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=BlogPost::class, inversedBy="blogImages")
     */
    private $blogPost;

    public function __construct()
    {
        $this->setOrdering(1);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrdering(): ?int
    {
        return $this->ordering;
    }

    public function setOrdering(int $ordering): self
    {
        $this->ordering = $ordering;

        return $this;
    }

    public function getSubtext(): ?string
    {
        return $this->subtext;
    }

    public function setSubtext(?string $subtext): self
    {
        $this->subtext = $subtext;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getBlogPost(): ?BlogPost
    {
        return $this->blogPost;
    }

    public function setBlogPost(?BlogPost $blogPost): self
    {
        if (empty($blogPost)) {
            return $this;
        }
        $this->blogPost = $blogPost;

        $blogImages = $blogPost->getBlogImages();
        if (!empty($blogImages)) {
            if (!in_array($this, array($blogImages))) {
                $this->setOrdering(count($blogImages));
            }
        }

        return $this;
    }
}
