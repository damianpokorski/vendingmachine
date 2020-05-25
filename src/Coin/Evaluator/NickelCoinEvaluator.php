<?php
namespace VendingMachine\Coin\Evaluator;

use VendingMachine\Coin\Definition\NickelCoin;
use VendingMachine\Coin\Contracts\CoinInterface;
use VendingMachine\Coin\Contracts\CoinEvaluatorInterface;

class NickelCoinEvaluator implements CoinEvaluatorInterface
{
    public function getValue(): float
    {
        return 0.05;
    }

    public function is(\VendingMachine\Coin\Contracts\CoinInterface $coin): bool
    {
        return $coin->getDiameter() == NickelCoin::$diameter && $coin->getWeight() == NickelCoin::$weight;
    }
    
    public function getCoinValue(CoinInterface $coin): ?float
    {
        return $this->is($coin) ? $this->getValue() : null;
    }
}
