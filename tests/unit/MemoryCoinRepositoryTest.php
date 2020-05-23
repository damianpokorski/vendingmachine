<?php

namespace VendingMachine\Tests\Feature;

use PHPUnit\Framework\TestCase;
use VendingMachine\Coin\Coin;
use VendingMachine\Coin\MemoryCoinRepository;

class MemoryCoinRepositoryTest extends TestCase
{
    public function testCanConstructMemoryCoinRepository()
    {
        $this->assertNotNull(new MemoryCoinRepository);
    }

    public function testCanAddCoinToRepositoryAndValidateContents()
    {
        $repository = new MemoryCoinRepository;
        $repository->add(new Coin);
        $this->assertNotEmpty($repository->contents());
    }

    public function testCanAddAndRemoveCoinsFromRepository()
    {
        // Define repository with 2 unique coins
        $repository = new MemoryCoinRepository;

        $coinA = new Coin(1, 0.5);
        $coinB = new Coin(0.5, 2);

        $repository->add($coinA);
        $repository->add($coinB);

        $this->assertCount(2, $repository->contents());
        
        $repository->remove($coinA);

        // Assert only remaining coin is CoinB
        $this->assertContains($coinB, $repository->contents());
        $this->assertEquals(0.5, $repository->contents()[0]->getDiameter());
        $this->assertEquals(2, $repository->contents()[0]->getWeight());
        $this->assertCount(1, $repository->contents());
    }
}
