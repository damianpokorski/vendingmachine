<?php
namespace VendingMachine\Coin\Definition;

use VendingMachine\Coin\Contracts\CoinInterface;

class QuarterCoin implements CoinInterface
{
    public static $weight = 5.57;
    public static $diameter = 24.26;

    public function getDiameter()
    {
        return static::$diameter;
    }

    public function getWeight()
    {
        return static::$weight;
    }
}
