<?php

namespace VendingMachine;

use Exception;
use VendingMachine\Coin\Contracts\CoinInterface;
use VendingMachine\Coin\Contracts\CoinRepositoryInterface;
use VendingMachine\Display\DisplayInterface;

class VendingMachine
{
    /**
     *
     * @var CoinRepositoryInterface
     */
    protected $bank;

    /**
     *
     * @var CoinRepositoryInterface
     */
    protected $pendingTransactionTray;

    /**
     *
     * @var CoinRepositoryInterface
     */
    protected $returnTray;

    /**
     *
     * @var DisplayInterface
     */
    protected $display;

    public function __construct(
        CoinRepositoryInterface $bank,
        CoinRepositoryInterface $pendingTransactionTray,
        CoinRepositoryInterface $returnTray,
        DisplayInterface $display
    ) {
        $this->bank = $bank;
        $this->pendingTransactionTray = $pendingTransactionTray;
        $this->returnTray = $returnTray;
        $this->display = $display;
    }

    public function insertCoin(CoinInterface $coin)
    {
        throw new Exception("Unimplemented feature");
    }
}
