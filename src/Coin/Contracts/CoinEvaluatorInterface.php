<?php

namespace VendingMachine\Coin\Contracts;

interface CoinEvaluatorInterface
{
    public function is(CoinInterface $coin): bool;
    /**
     * Returns the value of a coin or a null if the value is not correct
     *
     * @param CoinInterface $coin
     * @return float|null
     */
    public function getCoinValue(CoinInterface $coin): ?float;
}
