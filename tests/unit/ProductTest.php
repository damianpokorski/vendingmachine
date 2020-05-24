<?php

namespace VendingMachine\Tests\Feature;

use PHPUnit\Framework\TestCase;
use VendingMachine\Stock\Definition\CandyProduct;
use VendingMachine\Stock\Definition\ChipsProduct;
use VendingMachine\Stock\Definition\CokeProduct;
use VendingMachine\Stock\Product;

class ProductTest extends TestCase
{
    public function testCanConstructProduct()
    {
        $this->assertNotNull(new Product('Imaginary product', 0.01));
    }

    public function testValidateProductPrices()
    {
        $this->assertEquals(1.00, (new CokeProduct)->getPrice());
        $this->assertEquals(0.50, (new ChipsProduct)->getPrice());
        $this->assertEquals(0.65, (new CandyProduct)->getPrice());
    }

    public function testValidateProductNames()
    {
        $this->assertEquals('Coke', (new CokeProduct)->getName());
        $this->assertEquals('Chips', (new ChipsProduct)->getName());
        $this->assertEquals('Candy', (new CandyProduct)->getName());
    }
}
