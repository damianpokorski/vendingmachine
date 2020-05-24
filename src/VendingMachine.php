<?php

namespace VendingMachine;

use Exception;
use VendingMachine\Coin\Contracts\CoinEvaluatorInterface;
use VendingMachine\Coin\Contracts\CoinInterface;
use VendingMachine\CoinRepository\Contracts\CoinRepositoryInterface;
use VendingMachine\Display\Contracts\DisplayInterface;

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

    /**
     * Undocumented variable
     *
     * @var CoinEvaluatorInterface[]
     */
    protected $coinEvaluators;

    /**
     *
     * @param CoinRepositoryInterface $bank
     * @param CoinRepositoryInterface $pendingTransactionTray
     * @param CoinRepositoryInterface $returnTray
     * @param DisplayInterface $display
     * @param CoinEvaluatorInterface[] $coinEvaluators
     * @return void
     */
    public function __construct(
        $bank,
        $pendingTransactionTray,
        $returnTray,
        $display,
        $coinEvaluators = []
    ) {
        $this->bank = $bank;
        $this->pendingTransactionTray = $pendingTransactionTray;
        $this->returnTray = $returnTray;
        $this->display = $display;
        $this->coinEvaluators = $coinEvaluators;

        // If
        if (empty($this->pendingTransactionTray->contents())) {
            $this->display->setContent("INSERT COIN");
        }
    }

    /**
     * Iterates through the coin definition and returns first valid value
     * If no value is found - returns null
     *
     * @param CoinInterface $coin
     * @return float|null
     */
    private function getCoinValue(CoinInterface $coin)
    {
        foreach ($this->coinEvaluators as $evaluator) {
            $value = $evaluator->getCoinValue($coin);
            if (!is_null($value)) {
                return $value;
            }
        }
        return null;
    }

    /**
     * Handles the coin insertion logic
     *
     * @param CoinInterface $coin
     * @return void
     */
    public function insertCoin(CoinInterface $coin)
    {
        $coinValue = $this->getCoinValue($coin);

        // Coins without value are placed back in return tray
        if (\is_null($coinValue)) {
            $this->returnTray->add($coin);
            return;
        }
    }
}
