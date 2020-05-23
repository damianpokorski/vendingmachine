<?php

namespace VendingMachine\Tests\Feature;

use PHPUnit\Framework\TestCase;
use VendingMachine\Coin\Coin;
use VendingMachine\Coin\Definition\DimeCoin;
use VendingMachine\Coin\Definition\NickelCoin;
use VendingMachine\Coin\Definition\QuarterCoin;
use VendingMachine\Coin\Evaluator\DimeCoinEvaluator;
use VendingMachine\Coin\Evaluator\NickelCoinEvaluator;
use VendingMachine\Coin\Evaluator\QuarterCoinEvaluator;

class CoinTest extends TestCase
{
    public function testCanConstructCoin()
    {
        $this->assertNotNull(new Coin);
    }

    public function testCanIdentifyNickelCoinValue()
    {
        $this->assertEquals(0.05, (new NickelCoinEvaluator)->getCoinValue(new NickelCoin));

        // Ignores other coins
        $this->assertNull((new NickelCoinEvaluator)->getCoinValue(new DimeCoin));
        $this->assertNull((new NickelCoinEvaluator)->getCoinValue(new QuarterCoin));
    }


    public function testCanIdentifyDimeCoinValue()
    {
        $this->assertEquals(0.10, (new DimeCoinEvaluator)->getCoinValue(new DimeCoin));

        // Ignores other coins
        $this->assertNull((new DimeCoinEvaluator)->getCoinValue(new NickelCoin));
        $this->assertNull((new DimeCoinEvaluator)->getCoinValue(new QuarterCoin));
    }

    public function testCanIdentifyQuarterCoinValue() {
        $this->assertEquals(0.25, (new QuarterCoinEvaluator)->getCoinValue(new QuarterCoin));

        // Ignores other coins
        $this->assertNull((new QuarterCoinEvaluator)->getCoinValue(new DimeCoin));
        $this->assertNull((new QuarterCoinEvaluator)->getCoinValue(new NickelCoin));
    }
}
