<?php

namespace App\Tests\Entity;

use App\Entity\BlogPost;
use PHPUnit\Framework\TestCase;

class BlogPostTest extends TestCase
{
    public function testCanCreateBlogPost()
    {
        $blogPost = new BlogPost();
        $this->assertNotNull($blogPost);

        return $blogPost;
    }

    /**
     * @depends testCanCreateBlogPost
     */
    public function testCanSetTitle($blogPost)
    {
        $this->assertEmpty($blogPost->getTitle());

        $blogPost->setTitle("Test Title");
        $this->assertNotEmpty($blogPost->getTitle());

        return $blogPost;
    }

    /**
     * @depends testCanSetTitle
     */
    public function testCannotSetEmptyTitle($blogPost)
    {
        $this->assertNotEmpty($blogPost->getTitle());
        $blogPost->setTitle("");
        $this->assertNotEmpty($blogPost->getTitle());
    }
}
