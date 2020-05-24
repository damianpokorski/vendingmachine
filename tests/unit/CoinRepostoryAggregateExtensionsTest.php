<?php

namespace VendingMachine\Tests\Feature;

use VendingMachine\Coin\Coin;
use PHPUnit\Framework\TestCase;
use VendingMachine\Coin\Definition\DimeCoin;
use VendingMachine\Coin\Definition\NickelCoin;
use VendingMachine\Coin\Definition\QuarterCoin;
use VendingMachine\Coin\Evaluator\CommonEvaluators;
use VendingMachine\CoinRepository\MemoryCoinRepository;
use VendingMachine\CoinRepository\CoinRepositoryAggregateExtensions;

class CoinRepostoryAggregateExtensionsTest extends TestCase
{
    public function testCoinRepostoryAggregateExtensionsTotalValueWithValidCoins()
    {
        $repository = new MemoryCoinRepository();
        $repository->add(new DimeCoin);
        $repository->add(new NickelCoin);
        $repository->add(new QuarterCoin);

        $this->assertEquals(0.40, CoinRepositoryAggregateExtensions::totalValue($repository, CommonEvaluators::americanExceptPennies()));
    }

    public function testCoinRepostoryAggregateExtensionsWithInvalidCoins()
    {
        $repository = new MemoryCoinRepository();
        $repository->add(new Coin(-1, -1));
        $repository->add(new Coin);
        $repository->add(new Coin(9001, 9001));

        $this->assertEquals(0.0, CoinRepositoryAggregateExtensions::totalValue($repository, CommonEvaluators::americanExceptPennies()));
    }
}
