<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
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
    private $alt;

    /**
     * @ORM\Column(type="blob")
     */
    private $data;

    /**
     * @ORM\Column(type="integer")
     */
    private $width;

    /**
     * @ORM\Column(type="integer")
     */
    private $height;

    /**
     * @ORM\Column(type="integer")
     */
    private $length;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filetype;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function setFileAttributesWithImageFilePath($imagePath): self
    {
        $imgData = base64_encode(file_get_contents($imagePath));
        $imgLength = filesize($imagePath);
        $imgProps = getimagesize($imagePath);

        $imgWidth = $imgProps[0];
        $imgHeight = $imgProps[1];
        $imgType = $imgProps["mime"];

        $this->setData($imgData);
        $this->setFiletype($imgType);
        $this->setLength($imgLength);
        $this->setWidth($imgWidth);
        $this->setHeight($imgHeight);

        return $this;
    }

    public function getParsedImageSrc()
    {
        return 'data:' . $this->getFiletype() . ';base64,' . $this->readData();
    }

    public function getFiletype(): ?string
    {
        return $this->filetype;
    }

    public function setFiletype(string $filetype): self
    {
        $this->filetype = $filetype;

        return $this;
    }

    public function readData()
    {
        $data = '';
        while(!feof($this->getData())){
            $data.= fread($this->getData(), $this->getLength());
        }
        rewind($this->getData());
        return $data;
    }
}
