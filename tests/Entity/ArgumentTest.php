<?php

namespace App\Tests\Entity;

use App\Entity\Argument;
use PHPUnit\Framework\TestCase;

class ArgumentTest extends TestCase
{
    public function testCanCreateInstitutionObject()
    {
        $this->assertNotEmpty(new Argument());
    }

    public function testHasCorrectFields()
    {
        $this->assertClassHasAttribute('side', 'App\Entity\Argument');
        $this->assertClassHasAttribute('text', 'App\Entity\Argument');
        $this->assertClassHasAttribute('parent', 'App\Entity\Argument');
        $this->assertClassHasAttribute('child', 'App\Entity\Argument');

    }

}
