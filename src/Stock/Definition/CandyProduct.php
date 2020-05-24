<?php

namespace VendingMachine\Stock\Definition;

use VendingMachine\Stock\Contracts\ProductInterface;

class CandyProduct implements ProductInterface
{
    public function getName(): string
    {
        return 'Candy';
    }

    public function getPrice(): float
    {
        return 0.65;
    }
}
