<?php

namespace VendingMachine\Tests\Feature;

use PHPUnit\Framework\TestCase;
use VendingMachine\Coins\Coin;
use VendingMachine\VendingMachine;

class VendingMachineAcceptCoinsFeature extends TestCase
{
    public function testAcceptCoinFeature()
    {
        $vendingMachine = new VendingMachine();
        $this->assertFalse($vendingMachine->acceptCoin(new Coin()));
    }
}
