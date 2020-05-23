<?php

namespace VendingMachine\Coin\Contracts;

interface CoinInterface
{
    public function getDiameter(): float;
    public function getWeight(): float;
}
