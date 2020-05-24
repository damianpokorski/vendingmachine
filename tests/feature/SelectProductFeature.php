<?php

namespace VendingMachine\Tests\Feature;

use VendingMachine\Coin\Coin;
use VendingMachine\Coin\Definition\QuarterCoin;
use VendingMachine\VendingMachine;
use VendingMachine\Stock\Contracts\StockInterface;
use VendingMachine\Display\Contracts\DisplayInterface;
use VendingMachine\Tests\BaseVendingMachineFeatureTest;
use VendingMachine\CoinRepository\Contracts\CoinRepositoryInterface;
use VendingMachine\Stock\Definition\CokeProduct;

class SelectProductFeature extends BaseVendingMachineFeatureTest
{
    /**
     * @dataProvider vendingMachineDataProvider
     * @param VendingMachine $vendingMachine
     * @param CoinRepositoryInterface $bank
     * @param CoinRepositoryInterface $pendingTransactionTray
     * @param CoinRepositoryInterface $returnTray
     * @param DisplayInterface $display
     * @param CoinEvaluatorInterface[] $coinEvaluators
     * @param StockInterface[] $coinEvaluators
     */
    public function testDisposeProductWithExactChangeShowsThankYouMessage(
        $vendingMachine,
        $bank,
        $pendingTransactionTray,
        $returnTray,
        $display,
        $coinEvaluators,
        $stock
    ) {
        // Insert exact change for a coke
        $vendingMachine->insertCoin(new QuarterCoin);
        $vendingMachine->insertCoin(new QuarterCoin);
        $vendingMachine->insertCoin(new QuarterCoin);
        $vendingMachine->insertCoin(new QuarterCoin);
        

        // Select product
        $vendingMachine->selectProduct(new CokeProduct);

        // Assest successful message after purchase
        $this->assertEquals('THANK YOU', $display->getContent());
    }

    /**
     * @dataProvider vendingMachineDataProvider
     * @param VendingMachine $vendingMachine
     * @param CoinRepositoryInterface $bank
     * @param CoinRepositoryInterface $pendingTransactionTray
     * @param CoinRepositoryInterface $returnTray
     * @param DisplayInterface $display
     * @param CoinEvaluatorInterface[] $coinEvaluators
     * @param StockInterface[] $coinEvaluators
     */
    public function testDisposeProductWithExactChangeShowsThankYouMessageFollowedByInsertCoinAndEmptyingPendingTransactionTray(
        $vendingMachine,
        $bank,
        $pendingTransactionTray,
        $returnTray,
        $display,
        $coinEvaluators,
        $stock
    ) {
        // Insert exact change for a coke
        $vendingMachine->insertCoin(new QuarterCoin);
        $vendingMachine->insertCoin(new QuarterCoin);
        $vendingMachine->insertCoin(new QuarterCoin);
        $vendingMachine->insertCoin(new QuarterCoin);
        

        // Select product
        $vendingMachine->selectProduct(new CokeProduct);

        // Assest successful message after purchase
        $this->assertEquals('THANK YOU', $display->getContent());

        // Assest successful message after purchase
        $this->assertEquals('INSERT COIN', $display->getContent());

        // Assert the displayed value is still insert coin as we have yet to insert a valid coin
        $this->assertEmpty($pendingTransactionTray->contents());
    }

    /**
     * @dataProvider vendingMachineDataProvider
     * @param VendingMachine $vendingMachine
     * @param CoinRepositoryInterface $bank
     * @param CoinRepositoryInterface $pendingTransactionTray
     * @param CoinRepositoryInterface $returnTray
     * @param DisplayInterface $display
     * @param CoinEvaluatorInterface[] $coinEvaluators
     * @param StockInterface[] $coinEvaluators
     */
    public function testDisposalWithoutAnyFundsShowsItemPriceThenInsertCoinMessage(
        $vendingMachine,
        $bank,
        $pendingTransactionTray,
        $returnTray,
        $display,
        $coinEvaluators,
        $stock
    ) {

        // Select product
        $vendingMachine->selectProduct(new CokeProduct);

        // Assert the displayed value is still insert coin as we have yet to insert a valid coin
        $this->assertEquals('PRICE 1.00', $display->getContent());

        // Subsequent checks display INSERT COIN
        $this->assertEquals('INSERT COIN', $display->getContent());
    }
}
