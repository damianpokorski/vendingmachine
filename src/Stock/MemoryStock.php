<?php

namespace VendingMachine\Stock;

use VendingMachine\Stock\Contracts\StockInterface;

class MemoryStock implements StockInterface
{
    /**
     *
     * @var \VendingMachine\Stock\Contracts\ProductInterface
     */
    protected $product;

    /**
     * @var int
     */
    protected $quantity;
    /**
     * @param \VendingMachine\Stock\Contracts\ProductInterface $product
     * @param int $quantity
     */
    public function __construct($product, $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function dispose(): void
    {
        $this->quantity = $this->quantity -1;
    }
}
