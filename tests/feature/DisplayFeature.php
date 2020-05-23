<?php

namespace VendingMachine\Tests\Feature;

use PHPUnit\Framework\TestCase;
use VendingMachine\Coin\MemoryCoinRepository;
use VendingMachine\Display\MemoryDisplay;
use VendingMachine\VendingMachine;

class DisplayInsertCoinWhenNoCoinsInsertedFeature extends TestCase
{

    public function testDisplayInsertCoinWhenNoCoinsInsertedFeature()
    {
        // Defining display through dependency injection allows us to read the contents without
        // accessing it directly through the vending machine

        $display = new MemoryDisplay;
        
        $vendingMachine = new VendingMachine(
            new MemoryCoinRepository,
            new MemoryCoinRepository,
            new MemoryCoinRepository,
            $display
        );

        $this->assertEquals("INSERT COIN", $display->getContent());
    }
}
