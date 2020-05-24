<?php

namespace VendingMachine\Tests\Feature;

use VendingMachine\Coin\Definition\DimeCoin;
use VendingMachine\Coin\Definition\NickelCoin;
use VendingMachine\Coin\Definition\QuarterCoin;
use VendingMachine\CoinRepository\CoinRepositoryAggregateExtensions;
use VendingMachine\VendingMachine;
use VendingMachine\Stock\Contracts\StockInterface;
use VendingMachine\Display\Contracts\DisplayInterface;
use VendingMachine\Tests\BaseVendingMachineFeatureTest;
use VendingMachine\CoinRepository\Contracts\CoinRepositoryInterface;
use VendingMachine\Stock\Definition\CandyProduct;

class ReturnCoinsFeature extends BaseVendingMachineFeatureTest
{
    /**
     * @dataProvider vendingMachineDataProvider
     * @param VendingMachine $vendingMachine
     * @param CoinRepositoryInterface $bank
     * @param CoinRepositoryInterface $pendingTransactionTray
     * @param CoinRepositoryInterface $returnTray
     * @param DisplayInterface $display
     * @param CoinEvaluatorInterface[] $coinEvaluators
     * @param StockInterface[] $stock
     */
    public function testCanReturnCoins(
        $vendingMachine,
        $bank,
        $pendingTransactionTray,
        $returnTray,
        $display,
        $coinEvaluators,
        $stock
    ) {
        // Insert 75c
        $vendingMachine->insertCoin(new QuarterCoin);
        $vendingMachine->insertCoin(new QuarterCoin);
        $vendingMachine->insertCoin(new QuarterCoin);

        // Select product with a cost of 65c
        $vendingMachine->returnCoins();

        // Assert coins have been returned
        $this->assertEquals(0.75, CoinRepositoryAggregateExtensions::totalValue($returnTray, $coinEvaluators));

        // Assest successful message after purchase
        $this->assertEquals('INSERT COIN', $display->getContent());
    }
}
