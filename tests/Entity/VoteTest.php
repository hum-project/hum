<?php

namespace App\Tests\Entity;

use App\Entity\Vote;
use PHPUnit\Framework\TestCase;

class VoteTest extends TestCase
{
    public function testCanCreateVoteObject()
    {
        $this->assertNotEmpty(new Vote());
    }

    public function testHasCorrectFields()
    {
        $this->assertClassHasAttribute('policy', 'App\Entity\Vote');
        $this->assertClassHasAttribute('yes', 'App\Entity\Vote');
        $this->assertClassHasAttribute('no', 'App\Entity\Vote');
        $this->assertClassHasAttribute('abstain', 'App\Entity\Vote');
        $this->assertClassHasAttribute('absent', 'App\Entity\Vote');
    }
}
