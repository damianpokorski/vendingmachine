<?php

namespace VendingMachine\Coin\Contracts;

interface CoinInterface
{
    /**
     * Diameter definition in millimiters
     *
     * @return float
     */
    public function getDiameter();

    /**
     * Weight definition in grams
     *
     * @return float
     */
    public function getWeight();
}
