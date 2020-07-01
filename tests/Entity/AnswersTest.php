<?php

namespace App\Tests\Entity;

use App\Entity\ContinuousAnswer;
use App\Entity\NominalAnswer;
use App\Entity\OrdinalAnswer;
use PHPUnit\Framework\TestCase;

class AnswersTest extends TestCase
{
    public function testCanCreateAnswerEntities()
    {
        $this->assertNotEmpty(new ContinuousAnswer());
        $this->assertNotEmpty(new NominalAnswer());
        $this->assertNotEmpty(new OrdinalAnswer());
    }

    public function testAnswerEntitiesHasCorrectFields()
    {
        $continous = new ContinuousAnswer();
        $continous->setValue(10);
        $this->assertIsInt($continous->getValue());

        $nominal = new NominalAnswer();
        $nominal->setValue(10);
        $this->assertIsString($nominal->getValue());

        $ordinal = new OrdinalAnswer();
        $ordinal->setValue(3);
        $this->assertIsInt($ordinal->getValue());

        $this->assertClassHasAttribute('question', 'App\Entity\ContinuousAnswer');
        $this->assertClassHasAttribute('question', 'App\Entity\NominalAnswer');
        $this->assertClassHasAttribute('question', 'App\Entity\OrdinalAnswer');
    }

    public function testOrdinalValueWithinLimits()
    {
        $ordinal = new OrdinalAnswer();
        $ordinal->setScale(5);
        $ordinal->setValue(3);
        $ordinal->setValue(8);
        $this->assertNotEquals(8, $ordinal->getValue());

        $ordinal->setValue(0);
        $this->assertNotEquals(0, $ordinal->getValue());
    }

}
