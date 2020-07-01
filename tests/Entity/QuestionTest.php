<?php

namespace App\Tests\Entity;

use App\Entity\Question;
use PHPUnit\Framework\TestCase;

class QuestionTest extends TestCase
{
    public function testCanCreateQuestion()
    {
        $this->assertNotEmpty(new Question());
    }

    public function testHasCorrectFields()
    {
        $this->assertClassHasAttribute("hum", "App\Entity\Question");
        $this->assertClassHasAttribute("text", "App\Entity\Question");
    }
}
