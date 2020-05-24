<?php

namespace VendingMachine\Tests\Feature;

use PHPUnit\Framework\TestCase;
use VendingMachine\Coin\Definition\QuarterCoin;
use VendingMachine\CoinRepository\MemoryCoinRepository;
use VendingMachine\Display\MemoryDisplay;
use VendingMachine\Tests\BaseVendingMachineFeatureTest;
use VendingMachine\VendingMachine;

class DisplayInsertCoinWhenNoCoinsInsertedFeature extends BaseVendingMachineFeatureTest
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

    /**
     * @dataProvider vendingMachineDataProvider
     * @param VendingMachine $vendingMachine
     * @param CoinRepositoryInterface $bank
     * @param CoinRepositoryInterface $pendingTransactionTray
     * @param CoinRepositoryInterface $returnTray
     * @param DisplayInterface $display
     * @param CoinEvaluatorInterface[] $coinEvaluators
     */
    public function testDisplayTotalValueOfPendingTransactionCoins(
        $vendingMachine,
        $bank,
        $pendingTransactionTray,
        $returnTray,
        $display,
        $coinEvaluators
    ) {
        // Assert the displayed value before coin insertion
        $this->assertEquals('INSERT COIN', $display->getContent());

        // Inserting invalid coin
        $vendingMachine->insertCoin(new QuarterCoin);
        $vendingMachine->insertCoin(new QuarterCoin);

        // Assert the displayed value is still insert coin as we have yet to insert a valid coin
        $this->assertEquals('0.50', $display->getContent());
    }
}
