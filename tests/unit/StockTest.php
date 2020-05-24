<?php

namespace VendingMachine\Tests\Feature;

use PHPUnit\Framework\TestCase;
use VendingMachine\Stock\Definition\CandyProduct;
use VendingMachine\Stock\Definition\ChipsProduct;
use VendingMachine\Stock\Definition\CokeProduct;
use VendingMachine\Stock\MemoryStock;
use VendingMachine\Stock\Product;

class StockTest extends TestCase
{
    public function testCanConstructMemoryStock()
    {
        $this->assertNotNull(new MemoryStock(new Product('Imaginary product', 0.01), 10));
    }

    public function testStockDisposalDecrementsQuantity() {
        $stock = new MemoryStock(new Product('Imaginary product', 0.01), 10);

        // Assest stock quantity before disposal
        $this->assertEquals(10, $stock->getQuantity());

        // Dispose
        $stock->dispose();

        // 
        $this->assertEquals(9, $stock->getQuantity());
    }
}
