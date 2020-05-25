<?php

namespace VendingMachine\Tests\Feature;

use VendingMachine\VendingMachine;
use VendingMachine\Stock\MemoryStock;
use VendingMachine\Display\MemoryDisplay;
use VendingMachine\Stock\Definition\CokeProduct;
use VendingMachine\Coin\Evaluator\CommonEvaluators;
use VendingMachine\CoinRepository\MemoryCoinRepository;
use VendingMachine\Tests\BaseVendingMachineFeatureTest;

class ExactChangeOnlyFeature extends BaseVendingMachineFeatureTest
{
    public function testDisplayExactChangeOnlyIfThereIsNoChangeAvailable()
    {

        $bank = new MemoryCoinRepository;
        $pendingTransactionTray = new MemoryCoinRepository;
        $returnTray = new MemoryCoinRepository;
        $display = new MemoryDisplay;
        $evaluators = CommonEvaluators::americanExceptPennies();
        $stock = [ new MemoryStock(new CokeProduct, 10)];

        $vendingMachine = new VendingMachine(
            $bank,
            $pendingTransactionTray,
            $returnTray,
            $display,
            $evaluators,
            $stock
        );
        
        $this->assertEquals('EXACT CHANGE ONLY', $display->getContent());
    }
}
