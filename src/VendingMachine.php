<?php

namespace VendingMachine;

use Exception;
use VendingMachine\Coin\Contracts\CoinInterface;
use VendingMachine\Coin\Contracts\CoinRepositoryInterface;

class VendingMachine
{
    /**
     *
     * @var CoinRepositoryInterface
     */
    private $bank;

    /**
     *
     * @var CoinRepositoryInterface
     */
    private $pendingTransactionTray;

    /**
     *
     * @var CoinRepositoryInterface
     */
    private $returnTray;

    public function __construct(CoinRepositoryInterface $bank, CoinRepositoryInterface $pendingTransactionTray, CoinRepositoryInterface $returnTray)
    {
        $this->bank = $bank;
        $this->pendingTransactionTray = $pendingTransactionTray;
        $this->returnTray = $returnTray;
    }

    public function insertCoin(CoinInterface $coin) {
        throw new Exception("Unimplemented feature");
    }
}
