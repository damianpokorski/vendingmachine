<?php

namespace VendingMachine\Coin\Evaluator;

use VendingMachine\Coin\Evaluator\DimeCoinEvaluator;
use VendingMachine\Coin\Evaluator\NickelCoinEvaluator;
use VendingMachine\Coin\Evaluator\QuarterCoinEvaluator;

class CommonEvaluators
{
    /**
     * Helper method which containers american coin evaluators for shorthand definition
     *
     * @return CoinEvaluatorInterface[]
     */
    public static function american()
    {
        return [
            new DimeCoinEvaluator,
            new NickelCoinEvaluator,
            new QuarterCoinEvaluator
        ];
    }
}
