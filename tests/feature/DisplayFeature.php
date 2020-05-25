<?php

namespace VendingMachine\Tests\Feature;

use PHPUnit\Framework\TestCase;
use VendingMachine\Coin\Definition\QuarterCoin;
use VendingMachine\CoinRepository\MemoryCoinRepository;
use VendingMachine\Display\MemoryDisplay;
use VendingMachine\Tests\BaseVendingMachineFeatureTest;
use VendingMachine\VendingMachine;

class DisplayFeature extends BaseVendingMachineFeatureTest
{
    /**
    * @dataProvider vendingMachineDataProvider
    * @param VendingMachine $vendingMachine
    * @param CoinRepositoryInterface $bank
    * @param CoinRepositoryInterface $pendingTransactionTray
    * @param CoinRepositoryInterface $returnTray
    * @param DisplayInterface $display
    * @param CoinEvaluatorInterface[] $coinEvaluators
    */
    public function testDisplayInsertCoinWhenNoCoinsInsertedFeature(
        $vendingMachine,
        $bank,
        $pendingTransactionTray,
        $returnTray,
        $display,
        $coinEvaluators
    ) {
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
