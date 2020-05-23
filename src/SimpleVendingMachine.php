<?php

namespace VendingMachine;

use VendingMachine\Coin\MemoryCoinRepository;
use VendingMachine\Display\MemoryDisplay;
use VendingMachine\VendingMachine;

class SimpleVendingMachine extends VendingMachine
{
    public function __construct()
    {
        parent::__construct(
            new MemoryCoinRepository,
            new MemoryCoinRepository,
            new MemoryCoinRepository,
            new MemoryDisplay
        );
    }
}
