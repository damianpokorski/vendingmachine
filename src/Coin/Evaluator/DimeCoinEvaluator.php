<?php
namespace VendingMachine\Coin\Evaluator;

use VendingMachine\Coin\Definition\DimeCoin;

use VendingMachine\Coin\Contracts\CoinInterface;
use VendingMachine\Coin\Contracts\CoinEvaluatorInterface;

class DimeCoinEvaluator implements CoinEvaluatorInterface
{
    public function getCoinValue(CoinInterface $coin): ?float
    {
        if ($coin->getDiameter() == DimeCoin::$diameter && $coin->getWeight() == DimeCoin::$weight) {
            return 0.10;
        }

        return null;
    }
}
