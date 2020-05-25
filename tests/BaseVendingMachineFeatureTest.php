<?php

namespace VendingMachine\Tests;

use PHPUnit\Framework\TestCase;
use VendingMachine\VendingMachine;
use VendingMachine\Stock\MemoryStock;
use VendingMachine\Display\MemoryDisplay;
use VendingMachine\Coin\Definition\DimeCoin;
use VendingMachine\Coin\Definition\NickelCoin;
use VendingMachine\Coin\Definition\QuarterCoin;
use VendingMachine\Stock\Definition\CokeProduct;
use VendingMachine\Stock\Definition\CandyProduct;
use VendingMachine\Stock\Definition\ChipsProduct;
use VendingMachine\Coin\Evaluator\CommonEvaluators;
use VendingMachine\CoinRepository\MemoryCoinRepository;

abstract class BaseVendingMachineFeatureTest extends TestCase
{
    public function vendingMachineDataProvider()
    {
        $bank = new MemoryCoinRepository;
        $bank->add(new NickelCoin);
        $bank->add(new DimeCoin);
        $bank->add(new QuarterCoin);

        $pendingTransactionTray = new MemoryCoinRepository;
        $returnTray = new MemoryCoinRepository;
        $display = new MemoryDisplay;
        $evaluators = CommonEvaluators::americanExceptPennies();
        $stock = [
            new MemoryStock(new CokeProduct, 10),
            new MemoryStock(new ChipsProduct, 10),
            new MemoryStock(new CandyProduct, 10),
        ];

        yield [
            new VendingMachine(
                $bank,
                $pendingTransactionTray,
                $returnTray,
                $display,
                $evaluators,
                $stock
            ),
            $bank,
            $pendingTransactionTray,
            $returnTray,
            $display,
            $evaluators,
            $stock
        ];
    }
}