<?php
namespace VendingMachine\Coin\Evaluator;

use VendingMachine\Coin\Definition\DimeCoin;

use VendingMachine\Coin\Contracts\CoinInterface;
use VendingMachine\Coin\Contracts\CoinEvaluatorInterface;

class DimeCoinEvaluator implements CoinEvaluatorInterface
{
    public function is(\VendingMachine\Coin\Contracts\CoinInterface $coin): bool
    {
        return $coin->getDiameter() == DimeCoin::$diameter && $coin->getWeight() == DimeCoin::$weight;
    }
    
    public function getCoinValue(CoinInterface $coin): ?float
    {
        return static::is($coin) ? 0.10 : null;
    }
}
