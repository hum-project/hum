<?php

namespace App\Tests\Entity;

use App\Entity\BlogImage;
use App\Entity\BlogPost;
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

    public function testIncrementsOrderingWhenSharingBlogPost()
    {
        $blogPost = new BlogPost();
        $blogPost->setTitle("Testing");

        $blogImage1 = new BlogImage();
        $blogImage2 = new BlogImage();
        $blogImage1->setBlogPost($blogPost);
        $blogPost->addBlogImage($blogImage1);
        $blogImage2->setBlogPost($blogPost);
        $blogPost->addBlogImage($blogImage2);


        $this->assertEquals(1, $blogImage1->getOrdering());
        $this->assertEquals(2, $blogImage2->getOrdering());
    }
}
