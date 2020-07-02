<?php

namespace App\Entity;

use App\Repository\BlogPostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogPostRepository::class)
 */
class BlogPost
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
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="datetime")
     */
    private $entered;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modified;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishTime;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="blogPosts")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=BlogImage::class, mappedBy="blogPost")
     */
    private $blogImages;

    public function __construct()
    {
        $this->blogImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        if (!empty($title)) {
            $this->title = $title;
        }
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

    public function getEntered(): ?\DateTimeInterface
    {
        return $this->entered;
    }

    public function setEntered(\DateTimeInterface $entered): self
    {
        $this->entered = new \DateTime($entered->format('Y-m-d H:i:s'));
        $this->modified = new \DateTime($entered->format('Y-m-d H:i:s'));
        $minutes = $entered->format("i");
        $entered->modify("+1 hour");
        $entered->modify("-" . $minutes . " minutes");
        $this->publishTime = $entered;

        return $this;
    }

    public function getModified(): ?\DateTimeInterface
    {
        return $this->modified;
    }

    public function setModified(?\DateTimeInterface $modified): self
    {
        $this->modified = $modified;

        return $this;
    }

    public function getPublishTime(): ?\DateTimeInterface
    {
        return $this->publishTime;
    }

    public function setPublishTime(?\DateTimeInterface $publishTime): self
    {
        $this->publishTime = $publishTime;

        return $this;
    }

    public function updateSlug() : bool
    {
        $hasUpdated = false;
        if (!empty($this->getPublishTime()) && !empty($this->getTitle())) {
            $slug = substr($this->getPublishTime()->format("Y-m-d H:i:s"), 0, 10);
            $slug .= "_";
            $title_slug = str_replace(" ", "_", $this->getTitle());
            $slug .= $title_slug;
            $this->setSlug($slug);
            $hasUpdated = true;
        }

        return $hasUpdated;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|BlogImage[]
     */
    public function getBlogImages(): Collection
    {
        return $this->blogImages;
    }

    public function addBlogImage(BlogImage $blogImage): self
    {
        if (!$this->blogImages->contains($blogImage)) {
            $this->blogImages[] = $blogImage;
            $blogImage->setBlogPost($this);
        }

        return $this;
    }

    public function removeBlogImage(BlogImage $blogImage): self
    {
        if ($this->blogImages->contains($blogImage)) {
            $this->blogImages->removeElement($blogImage);
            // set the owning side to null (unless already changed)
            if ($blogImage->getBlogPost() === $this) {
                $blogImage->setBlogPost(null);
            }
        }

        return $this;
    }
}
