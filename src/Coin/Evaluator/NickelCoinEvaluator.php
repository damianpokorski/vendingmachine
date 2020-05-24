<?php
namespace VendingMachine\Coin\Evaluator;

use VendingMachine\Coin\Definition\NickelCoin;
use VendingMachine\Coin\Contracts\CoinInterface;
use VendingMachine\Coin\Contracts\CoinEvaluatorInterface;

class NickelCoinEvaluator implements CoinEvaluatorInterface
{
    public function is(\VendingMachine\Coin\Contracts\CoinInterface $coin): bool
    {
        return $coin->getDiameter() == NickelCoin::$diameter && $coin->getWeight() == NickelCoin::$weight;
    }
    
    public function getCoinValue(CoinInterface $coin): ?float
    {
        return static::is($coin) ? 0.05 : null;
    }
}
