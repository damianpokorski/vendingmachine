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

class MakeChangeFeature extends BaseVendingMachineFeatureTest
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
    public function testCanMakeChange(
        $vendingMachine,
        $bank,
        $pendingTransactionTray,
        $returnTray,
        $display,
        $coinEvaluators,
        $stock
    ) {
        // Add change to the bank
        for ($i = 0; $i < 10; $i++) {
            $bank->add(new NickelCoin);
            $bank->add(new DimeCoin);
            $bank->add(new QuarterCoin);
        }


        // Insert 75c
        $vendingMachine->insertCoin(new QuarterCoin);
        $vendingMachine->insertCoin(new QuarterCoin);
        $vendingMachine->insertCoin(new QuarterCoin);

        // Select product with a cost of 65c
        $vendingMachine->selectProduct(new CandyProduct);

        // Assest successful message after purchase
        $this->assertEquals('THANK YOU', $display->getContent());

        $this->assertEquals(0.10, CoinRepositoryAggregateExtensions::totalValue($returnTray, $coinEvaluators));
    }
}
