<?php

namespace VendingMachine\Tests\Feature;

use PHPUnit\Framework\TestCase;
use VendingMachine\Coin\Coin;

class CoinTest extends TestCase
{
    public function testCanConstructCoin()
    {
        $this->assertNotNull(new Coin);
    }
}
