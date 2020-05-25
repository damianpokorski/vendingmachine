<?php
namespace VendingMachine\Coin\Evaluator;

use VendingMachine\Coin\Definition\QuarterCoin;
use VendingMachine\Coin\Contracts\CoinInterface;
use VendingMachine\Coin\Contracts\CoinEvaluatorInterface;

class QuarterCoinEvaluator implements CoinEvaluatorInterface
{
    public function getValue(): float
    {
        return 0.25;
    }

    public function is(\VendingMachine\Coin\Contracts\CoinInterface $coin): bool
    {
        return $coin->getDiameter() == QuarterCoin::$diameter && $coin->getWeight() == QuarterCoin::$weight;
    }

    public function getCoinValue(CoinInterface $coin): ?float
    {
        return $this->is($coin) ? $this->getValue() : null;
    }
}
