<?php
namespace VendingMachine\Coin\Definition;

use VendingMachine\Coin\Contracts\CoinInterface;

class DimeCoin implements CoinInterface
{
    public static $weight = 2.268;
    public static $diameter = 17.91;

    public function getDiameter()
    {
        return static::$diameter;
    }

    public function getWeight()
    {
        return static::$weight;
    }
}
