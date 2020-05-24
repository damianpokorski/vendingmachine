<?php

namespace VendingMachine\Stock\Contracts;

interface ProductInterface
{
    /**
     * Gets the name of the product
     *
     * @return string
     */
    public function getName();

    /**
     * Gets the product price
     *
     * @return float
     */
    public function getPrice();
}
