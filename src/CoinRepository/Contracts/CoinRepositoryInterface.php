<?php

namespace VendingMachine\CoinRepository\Contracts;

use VendingMachine\Coin\Contracts\CoinInterface;

interface CoinRepositoryInterface
{
    /**
     * Adds instance to the repository
     *
     * @param CoinInterface $coin
     * @return void
     */
    public function add(CoinInterface $coin): void;

    /**
     * Removes the instances from the repository
     *
     * @param CoinInterface $coin
     * @return void
     */
    public function remove(CoinInterface $coin): void;

    /**
     * Returns the contents of repository
     *
     * @return CoinInterface[]
     */
    public function contents();
}
