<?php

namespace VendingMachine\CoinRepository;

use VendingMachine\Coin\Contracts\CoinEvaluatorInterface;
use VendingMachine\Coin\Contracts\CoinInterface;
use VendingMachine\CoinRepository\Contracts\CoinRepositoryInterface;

class CoinRepositoryAggregateExtensions
{
    /**
     *
     * @param CoinRepositoryInterface  $repository
     * @param CoinEvaluatorInterface[] $evaluators
     * @return float
     */
    public static function totalValue($repository, $evaluators)
    {
        return array_reduce($repository->contents(), function (float $total, CoinInterface $coin) use ($evaluators) {
            foreach ($evaluators as $evaluator) {
                if ($evaluator->is($coin)) {
                    return $total + $evaluator->getCoinValue($coin);
                }
            }
            return $total;
        }, 0);
    }
}
