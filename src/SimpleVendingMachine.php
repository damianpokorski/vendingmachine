<?php

namespace VendingMachine;

use VendingMachine\Coin\Evaluator\DimeCoinEvaluator;
use VendingMachine\Coin\Evaluator\NickelCoinEvaluator;
use VendingMachine\Coin\Evaluator\QuarterCoinEvaluator;
use VendingMachine\CoinRepository\MemoryCoinRepository;
use VendingMachine\Display\MemoryDisplay;
use VendingMachine\VendingMachine;

class SimpleVendingMachine extends VendingMachine
{
    public function __construct()
    {
        parent::__construct(
            new MemoryCoinRepository,
            new MemoryCoinRepository,
            new MemoryCoinRepository,
            new MemoryDisplay,
            [
                new DimeCoinEvaluator,
                new NickelCoinEvaluator,
                new QuarterCoinEvaluator
            ]
        );
    }
}
