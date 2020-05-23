<?php
namespace VendingMachine\Coins;

use VendingMachine\Coins\Contracts\CoinInterface;

class Coin implements CoinInterface
{
    private $diameter;
    private $weight;
    public function __construct(float $diamater = 0, float $weight = 0)
    {
        $this->diameter = $diamater;
        $this->weight = $weight;
    }

    public function getDiameter(): float
    {
        return $this->diameter;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }
}
