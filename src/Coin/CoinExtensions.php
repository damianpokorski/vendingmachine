<?php

namespace VendingMachine\Coin;

use VendingMachine\Coin\Contracts\CoinEvaluatorInterface;
use VendingMachine\Coin\Contracts\CoinInterface;

class CoinExtensions
{
    /**
     * Iterates through the coin definition and returns first valid value
     * If no value is found - returns null
     *
     * @param CoinInterface $coin
     * @param CoinEvaluatorInterface[] $evaluators
     * @return float|null
     */
    public static function getCoinValue(CoinInterface $coin, $evaluators = [])
    {
        foreach ($evaluators as $evaluator) {
            if ($evaluator->is($coin)) {
                return $evaluator->getCoinValue($coin);
            }
        }
        return null;
    }
}
