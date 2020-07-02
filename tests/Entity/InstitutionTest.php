<?php

namespace App\Tests\Entity;

use App\Entity\Institution;
use PHPUnit\Framework\TestCase;

class InstitutionTest extends TestCase
{
    public function testCanCreateInstitutionObject()
    {
        $this->assertNotEmpty(new Institution());
    }

    public function testHasCorrectFields()
    {
        $this->assertClassHasAttribute('name', 'App\Entity\Institution');
        $this->assertClassHasAttribute('text', 'App\Entity\Institution');
        $this->assertClassHasAttribute('policyTheme', 'App\Entity\Institution');

    }

}
