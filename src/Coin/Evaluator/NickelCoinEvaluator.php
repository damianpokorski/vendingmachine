<?php
namespace VendingMachine\Coin\Evaluator;

use VendingMachine\Coin\Definition\NickelCoin;
use VendingMachine\Coin\Contracts\CoinInterface;
use VendingMachine\Coin\Contracts\CoinEvaluatorInterface;

class NickelCoinEvaluator implements CoinEvaluatorInterface
{
    public function getCoinValue(CoinInterface $coin): ?float
    {
        if ($coin->getDiameter() == NickelCoin::$diameter && $coin->getWeight() == NickelCoin::$weight) {
            return 0.05;
        }

        return null;
    }
}
