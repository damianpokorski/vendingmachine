<?php

namespace VendingMachine\Coins\Contracts;

interface CoinInterface
{
    public function getDiameter(): float;
    public function getWeight(): float;
}
