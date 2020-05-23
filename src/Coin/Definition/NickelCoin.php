<?php
namespace VendingMachine\Coin\Definition;

use VendingMachine\Coin\Contracts\CoinInterface;

class NickelCoin implements CoinInterface
{
    public static $weight = 5;
    public static $diameter = 21.21;

    public function getDiameter()
    {
        return static::$diameter;
    }

    public function getWeight()
    {
        return static::$weight;
    }
}
