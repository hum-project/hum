<?php

namespace App\Tests\Entity;

use App\Entity\Policy;
use PHPUnit\Framework\TestCase;

class PolicyTest extends TestCase
{
    public function testCanCreatePolicyObject()
    {
        $this->assertNotEmpty(new Policy());
    }

    public function testHasCorrectFields()
    {
        $this->assertClassHasAttribute('title', 'App\Entity\Policy');
        $this->assertClassHasAttribute('text', 'App\Entity\Policy');
        $this->assertClassHasAttribute('source', 'App\Entity\Policy');
        $this->assertClassHasAttribute('policyTheme', 'App\Entity\Policy');
        $this->assertClassHasAttribute('argument', 'App\Entity\Policy');
    }

}
