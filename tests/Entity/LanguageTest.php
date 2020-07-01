<?php

namespace App\Tests\Entity;

use App\Entity\Language;
use PHPUnit\Framework\TestCase;

class LanguageTest extends TestCase
{
    public function testCanCreateLanguageObject()
    {
        $this->assertNotEmpty(new Language());
    }

    public function testHasCorrectFields()
    {
        $this->assertClassHasAttribute('name', 'App\Entity\Language');
    }
}
