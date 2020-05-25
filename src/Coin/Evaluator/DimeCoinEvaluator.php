<?php
namespace VendingMachine\Coin\Evaluator;

use VendingMachine\Coin\Definition\DimeCoin;

use VendingMachine\Coin\Contracts\CoinInterface;
use VendingMachine\Coin\Contracts\CoinEvaluatorInterface;

class DimeCoinEvaluator implements CoinEvaluatorInterface
{
    public function getValue(): float
    {
        return 0.10;
    }

    public function is(\VendingMachine\Coin\Contracts\CoinInterface $coin): bool
    {
        return $coin->getDiameter() == DimeCoin::$diameter && $coin->getWeight() == DimeCoin::$weight;
    }
    
    public function getCoinValue(CoinInterface $coin): ?float
    {
        return $this->is($coin) ? $this->getValue() : null;
    }
}
