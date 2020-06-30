<?php

namespace App\Tests\Entity;

use App\Entity\BlogPost;
use PHPUnit\Framework\TestCase;

class BlogPostTest extends TestCase
{
    public function testCanCreateBlogPost() : BlogPost
    {
        $blogPost = new BlogPost();
        $this->assertNotNull($blogPost);

        return $blogPost;
    }

    /**
     * @depends testCanCreateBlogPost
     */
    public function testCanSetTitle(BlogPost $blogPost) : BlogPost
    {
        $this->assertEmpty($blogPost->getTitle());

        $blogPost->setTitle("Test Title");
        $this->assertNotEmpty($blogPost->getTitle());

        return $blogPost;
    }

    /**
     * @depends testCanSetTitle
     */
    public function testCannotSetEmptyTitle(BlogPost $blogPost)
    {
        $this->assertNotEmpty($blogPost->getTitle());
        $blogPost->setTitle("");
        $this->assertNotEmpty($blogPost->getTitle());
    }

    /**
     * @depends testCanCreateBlogPost
     */
    public function testCanSetDates(BlogPost $blogPost) :BlogPost
    {
        $this->assertNull($blogPost->getEntered());
        $this->assertNull($blogPost->getModified());
        $this->assertNull($blogPost->getPublishTime());

        $dateString = "2020-07-20 08:15:00";
        $blogPost->setEntered(new \DateTime($dateString));
        $this->assertNotNull($blogPost->getEntered());
        $this->assertNotNull($blogPost->getModified());
        $this->assertNotNull($blogPost->getPublishTime());

        $this->assertNotEquals($blogPost->getModified(), $blogPost->getPublishTime());
        $this->assertEquals($blogPost->getEntered(),$blogPost->getModified());
        $this->assertEquals("2020-07-20 09:00:00", $blogPost->getPublishTime()->format("Y-m-d H:i:s"));
        return $blogPost;
    }

    /**
     * @depends testCanSetTitle
     * @depends testCanSetDates
     */
    public function testCanUpdateSlug(BlogPost $blogPost)
    {
        $this->assertEmpty($blogPost->getSlug());
        $this->assertTrue($blogPost->updateSlug());
        $this->assertEquals("2020-07-20_Test_Title", $blogPost->getSlug());
    }
}
