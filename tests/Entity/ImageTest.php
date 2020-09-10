<?php

namespace App\Tests\Entity;

use App\Entity\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{

    public function testHasCorrectFields()
    {
        $this->assertClassHasAttribute('fileName', 'App\Entity\Image');
        $this->assertClassHasAttribute('alt', 'App\Entity\Image');
    }
}
