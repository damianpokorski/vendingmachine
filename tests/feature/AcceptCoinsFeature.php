<?php

namespace VendingMachine\Tests\Feature;

use PHPUnit\Framework\TestCase;
use VendingMachine\Coin\Coin;
use VendingMachine\SimpleVendingMachine;

class VendingMachineAcceptCoinFeature extends TestCase
{
    public function testAcceptCoinFeatureExists()
    {
        $vendingMachine = new SimpleVendingMachine;
        $this->assertTrue(method_exists($vendingMachine, 'insertCoin'));
    }

    public function testRejectInvalidCoin()
    {
        $vendingMachine = new SimpleVendingMachine;
        $vendingMachine->insertCoin(new Coin(-1, -1));
        
        
    }
}
