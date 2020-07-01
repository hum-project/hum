<?php

namespace App\Tests\Entity;

use App\Entity\PolicyTheme;
use PHPUnit\Framework\TestCase;

class PolicyThemeTest extends TestCase
{
    public function testCanCreatePolicyThemeObject()
    {
        $theme = new PolicyTheme();
        $this->assertNotEmpty($theme);
    }

    public function testHasCorrectFields()
    {
        $this->assertClassHasAttribute('title', 'App\Entity\PolicyTheme');
        $this->assertClassHasAttribute('symbol', 'App\Entity\PolicyTheme');
        $this->assertClassHasAttribute('text', 'App\Entity\PolicyTheme');
        $this->assertClassHasAttribute('policies', 'App\Entity\PolicyTheme');
    }

}
