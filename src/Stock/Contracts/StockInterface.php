<?php

namespace VendingMachine\Stock\Contracts;

interface StockInterface
{
    /**
     * Gets the product definition
     *
     * @return ProductInterface
     */
    public function getProduct();

    /**
     * Gets the available quantity
     *
     * @return integer
     */
    public function getQuantity();

    /**
     * Decreases available stock
     *
     * @return void
     */
    public function dispose();
}
