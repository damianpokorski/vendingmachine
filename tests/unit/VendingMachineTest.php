<?php

namespace VendingMachine\Tests\Feature;

use PHPUnit\Framework\TestCase;
use VendingMachine\VendingMachine;

class VendingMachineTest extends TestCase
{
    public function testCanConstructVendindMachine()
    {
        $this->assertNotNull(new VendingMachine);
    }
}
