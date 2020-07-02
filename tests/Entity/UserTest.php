<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testCanCreateInstitutionObject()
    {
        $this->assertNotEmpty(new User());
    }

    public function testHasCorrectFields()
    {
        $this->assertClassHasAttribute('username', 'App\Entity\User');
        $this->assertClassHasAttribute('email', 'App\Entity\User');
        $this->assertClassHasAttribute('roles', 'App\Entity\User');
        $this->assertClassHasAttribute('password', 'App\Entity\User');

    }
}
