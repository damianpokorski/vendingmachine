<?php

namespace VendingMachine\Stock\Definition;

use VendingMachine\Stock\Contracts\ProductInterface;

class CokeProduct implements ProductInterface
{
    public function getName(): string
    {
        return 'Coke';
    }

    public function getPrice(): float
    {
        return 1.00;
    }
}
