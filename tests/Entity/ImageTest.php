<?php

namespace App\Tests\Entity;

use App\Entity\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{

    public function testSetFileAttributesWithImageFilePath() : Image
    {
        $image = new Image();
        $filePath = '/../assets/image01.png';
        $image->setFileAttributesWithImageFilePath(dirname(__FILE__) . $filePath);
        $this->assertNotEmpty($image->getData());
        $this->assertNotEmpty($image->getHeight());
        $this->assertNotEmpty($image->getWidth());
        $this->assertNotEmpty($image->getLength());

        return $image;
    }

    /**
     * @depends testSetFileAttributesWithImageFilePath
     */
    public function testGetParsedImageSrc(Image $image)
    {
        $this->assertNotEmpty($image->getParsedImageSrc());
        $this->assertEquals("image/png", $image->getFiletype());
    }

    /**
     * @depends testSetFileAttributesWithImageFilePath
     */
    public function testHasAltField(Image $image)
    {
        $this->assertClassHasAttribute("alt", "App\Entity\Image");
    }
}
