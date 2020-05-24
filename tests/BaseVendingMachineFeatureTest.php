<?php

namespace VendingMachine\Tests;

use PHPUnit\Framework\TestCase;
use VendingMachine\VendingMachine;
use VendingMachine\Display\MemoryDisplay;
use VendingMachine\Coin\Evaluator\CommonEvaluators;
use VendingMachine\CoinRepository\MemoryCoinRepository;

abstract class BaseVendingMachineFeatureTest extends TestCase
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
}
