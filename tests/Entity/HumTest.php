<?php

namespace App\Tests\Entity;

use App\Entity\Hum;
use PHPUnit\Framework\TestCase;

class HumTest extends TestCase
{
    public function testCanCreateHum() : Hum
    {
        $hum = new Hum();
        $this->assertNotEmpty($hum);
        return $hum;
    }

    /**
     * @depends testCanCreateHum
     */
    public function testHasDateField(Hum $hum) : Hum
    {
        $this->assertClassHasAttribute("date", "App\Entity\Hum");
        return $hum;
    }

    /**
     * @depends testHasDateField
     */
    public function testDefaultDateIsSet(Hum $hum) : Hum
    {
        $this->assertNotEmpty($hum->getDate());

        return $hum;
    }

    /**
     * @depends testDefaultDateIsSet
     */
    public function testCanUpdateDate(Hum $hum)
    {
        $aDate = new \DateTime($hum->getDate()->format("Y-m-d H:i:s"));
        $hum->setDate(new \DateTime("2100-01-01 10:00:00"));
        $this->assertNotEquals($aDate, $hum->getDate());
    }
}
