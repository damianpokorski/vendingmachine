<?php

namespace VendingMachine\Tests\Feature;

use PHPUnit\Framework\TestCase;
use VendingMachine\Coin\Coin;
use VendingMachine\Coin\Definition\NickelCoin;
use VendingMachine\Coin\Evaluator\CommonEvaluators;
use VendingMachine\CoinRepository\MemoryCoinRepository;
use VendingMachine\Display\MemoryDisplay;
use VendingMachine\SimpleVendingMachine;
use VendingMachine\VendingMachine;

class VendingMachineAcceptCoinFeature extends TestCase
{
    public function testAcceptCoinFeatureExists()
    {
        $vendingMachine = new SimpleVendingMachine;
        $this->assertTrue(method_exists($vendingMachine, 'insertCoin'));
    }

    public function testRejectInvalidCoin()
    {
        $returnTray = new MemoryCoinRepository;
        $display = new MemoryDisplay;

        $vendingMachine = new VendingMachine(
            new MemoryCoinRepository,
            new MemoryCoinRepository,
            $returnTray,
            $display,
            CommonEvaluators::american()
        );
        
        // Assert the displayed value before coin insertion
        $this->assertEquals('INSERT COIN', $display->getContent());

        // Inserting invalid coin
        $invalidCoin = new Coin(-1, -1);
        $vendingMachine->insertCoin($invalidCoin);

        // Evaluating if the coin in the return tray is the invalid coin we have inserted
        $this->assertCount(1, $returnTray->contents());
        $this->assertEquals($returnTray->contents()[0]->getDiameter(), -1);
        $this->assertEquals($returnTray->contents()[0]->getWeight(), -1);


        // Assert the displayed value is still insert coin as we have yet to insert a valid coin
        $this->assertEquals('INSERT COIN', $display->getContent());
    }

    public function testAcceptValidCoin()
    {

        $pendingCoins = new MemoryCoinRepository;
        $display = new MemoryDisplay;

        $vendingMachine = new VendingMachine(
            new MemoryCoinRepository,
            $pendingCoins,
            new MemoryDisplay,
            $display,
            CommonEvaluators::american()
        );

        // Assert the displayed value before coin insertion
        $this->assertEquals('INSERT COIN', $display->getContent());


        // Assert the displayed value before coin insertion
        $vendingMachine->insertCoin(new NickelCoin);

        $this->assertCount(1, $pendingCoins->contents());
    }
}
