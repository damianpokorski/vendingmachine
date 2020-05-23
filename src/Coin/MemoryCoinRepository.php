<?php

namespace VendingMachine\Coin;

use VendingMachine\Coin\Contracts\CoinInterface;
use VendingMachine\Coin\Contracts\CoinRepositoryInterface;

class MemoryCoinRepository implements CoinRepositoryInterface
{
    /**
     * @var CoinInterface[]
     */
    private $storage = [];

    public function add(CoinInterface $coin): void
    {
        array_push($this->storage, $coin);
    }

    public function remove(CoinInterface $coin): void
    {
        if (in_array($coin, $this->storage)) {
            array_splice($this->storage, array_search($coin, $this->storage), 1);
        }
    }

    public function contents()
    {
        return $this->storage;
    }
}
