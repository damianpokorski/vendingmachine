<?php

namespace VendingMachine\Tests\Feature;

use VendingMachine\Coin\Coin;
use VendingMachine\VendingMachine;
use VendingMachine\SimpleVendingMachine;
use VendingMachine\Coin\Definition\NickelCoin;
use VendingMachine\Display\Contracts\DisplayInterface;
use VendingMachine\Tests\BaseVendingMachineFeatureTest;
use VendingMachine\CoinRepository\CoinRepositoryAggregateExtensions;
use VendingMachine\CoinRepository\Contracts\CoinRepositoryInterface;

class AcceptCoinFeature extends BaseVendingMachineFeatureTest
{
    public function testAcceptCoinFeatureExists()
    {
        $vendingMachine = new SimpleVendingMachine;
        $this->assertTrue(method_exists($vendingMachine, 'insertCoin'));
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
    public function testRejectInvalidCoin(
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
        $invalidCoin = new Coin(-1, -1);
        $vendingMachine->insertCoin($invalidCoin);

        // Evaluating if the coin in the return tray is the invalid coin we have inserted
        $this->assertCount(1, $returnTray->contents());
        $this->assertEquals($returnTray->contents()[0]->getDiameter(), -1);
        $this->assertEquals($returnTray->contents()[0]->getWeight(), -1);

        // Assert the displayed value is still insert coin as we have yet to insert a valid coin
        $this->assertEquals('INSERT COIN', $display->getContent());
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
    public function testAcceptValidCoin(
        $vendingMachine,
        $bank,
        $pendingTransactionTray,
        $returnTray,
        $display,
        $coinEvaluators
    ) {
        // Assert the displayed value before coin insertion
        $this->assertEquals('INSERT COIN', $display->getContent());

        // Assert the displayed value before coin insertion
        $vendingMachine->insertCoin(new NickelCoin);

        $this->assertCount(1, $pendingTransactionTray->contents());

        // Assert that the pending transaction tray value is 0.05
        $this->assertEquals(0.05, CoinRepositoryAggregateExtensions::totalValue($pendingTransactionTray, $coinEvaluators));
    }
}
