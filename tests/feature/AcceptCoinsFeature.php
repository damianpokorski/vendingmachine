<?php

namespace VendingMachine\Tests\Feature;

use VendingMachine\Coin\Coin;
use PHPUnit\Framework\TestCase;
use VendingMachine\VendingMachine;
use VendingMachine\SimpleVendingMachine;
use VendingMachine\Display\MemoryDisplay;
use VendingMachine\Coin\Definition\NickelCoin;
use VendingMachine\Coin\Evaluator\CommonEvaluators;
use VendingMachine\Display\Contracts\DisplayInterface;
use VendingMachine\CoinRepository\MemoryCoinRepository;
use VendingMachine\CoinRepository\Contracts\CoinRepositoryInterface;

class VendingMachineAcceptCoinFeature extends TestCase
{
    public function vendingMachineDataProvider()
    {
        $bank = new MemoryCoinRepository;
        $pendingTransactionTray = new MemoryCoinRepository;
        $returnTray = new MemoryCoinRepository;
        $display = new MemoryDisplay;
        $evaluators = CommonEvaluators::americanExceptPennies();

        yield [
            new VendingMachine(
                $bank,
                $pendingTransactionTray,
                $returnTray,
                $display,
                $evaluators
            ),
            $bank,
            $pendingTransactionTray,
            $returnTray,
            $display,
            $evaluators
        ];
    }

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
    }
}
