<?php
namespace VendingMachine\Coin\Evaluator;

use VendingMachine\Coin\Definition\QuarterCoin;
use VendingMachine\Coin\Contracts\CoinInterface;
use VendingMachine\Coin\Contracts\CoinEvaluatorInterface;

class QuarterCoinEvaluator implements CoinEvaluatorInterface
{
    public function getCoinValue(CoinInterface $coin): ?float
    {
        if ($coin->getDiameter() == QuarterCoin::$diameter && $coin->getWeight() == QuarterCoin::$weight) {
            return 0.25;
        }

        return null;
    }
}
