<?php

namespace App\Tests;

use App\Service\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testAdd()
    {
        $calculator = new Calculator();
        $result = $calculator->add(10, 20);

        $this->assertEquals(30, $result);
    }
}
