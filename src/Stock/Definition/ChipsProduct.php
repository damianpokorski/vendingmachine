<?php

namespace VendingMachine\Stock\Definition;

use VendingMachine\Stock\Contracts\ProductInterface;

class ChipsProduct implements ProductInterface
{
    public function getName(): string
    {
        return 'Chips';
    }

    public function getPrice(): float
    {
        return 0.50;
    }
}
