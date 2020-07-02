<?php

namespace App\Tests\Entity;

use App\Entity\BlogImage;
use PHPUnit\Framework\TestCase;

class BlogImageTest extends TestCase
{
    public function testCanCreateBlogImage()
    {
        $this->assertNotEmpty(new BlogImage());
    }

    public function testHasCorrectFields()
    {
        $this->assertClassHasAttribute('ordering', 'App\Entity\BlogImage');
        $this->assertClassHasAttribute('subtext', 'App\Entity\BlogImage');
        $this->assertClassHasAttribute('image', 'App\Entity\BlogImage');
        $this->assertClassHasAttribute('blogPost', 'App\Entity\BlogImage');
    }
}
