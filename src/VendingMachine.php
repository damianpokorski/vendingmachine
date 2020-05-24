<?php

namespace VendingMachine;

use Exception;
use VendingMachine\Coin\CoinExtensions;
use VendingMachine\Coin\Contracts\CoinInterface;
use VendingMachine\Stock\Contracts\StockInterface;
use VendingMachine\Display\Contracts\DisplayInterface;
use VendingMachine\Coin\Contracts\CoinEvaluatorInterface;
use VendingMachine\CoinRepository\CoinRepositoryAggregateExtensions;
use VendingMachine\CoinRepository\Contracts\CoinRepositoryInterface;
use VendingMachine\Stock\Contracts\ProductInterface;

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
     *
     * @var CoinEvaluatorInterface[]
     */
    protected $coinEvaluators;

    /**
     *
     * @var StockInterface[]
     */
    protected $stock;

    /**
     *
     * @param CoinRepositoryInterface $bank
     * @param CoinRepositoryInterface $pendingTransactionTray
     * @param CoinRepositoryInterface $returnTray
     * @param DisplayInterface $display
     * @param CoinEvaluatorInterface[] $coinEvaluators
     * @param StockInterface[] $stock
     * @return void
     */
    public function __construct(
        $bank,
        $pendingTransactionTray,
        $returnTray,
        $display,
        $coinEvaluators = [],
        $stock = []
    ) {
        $this->bank = $bank;
        $this->pendingTransactionTray = $pendingTransactionTray;
        $this->returnTray = $returnTray;
        $this->display = $display;
        $this->coinEvaluators = $coinEvaluators;
        $this->stock = $stock;

        // If
        if (empty($this->pendingTransactionTray->contents())) {
            $this->display->setContent("INSERT COIN");
        }
    }

    private function displayPendingTransactionTotal()
    {
        $totalValue = CoinRepositoryAggregateExtensions::totalValue($this->pendingTransactionTray, $this->coinEvaluators);
        $this->display->setContent(\money_format('%i', $totalValue));
    }

    /**
     * Handles the coin insertion logic
     *
     * @param CoinInterface $coin
     * @return void
     */
    public function insertCoin(CoinInterface $coin)
    {
        $coinValue = CoinExtensions::getCoinValue($coin, $this->coinEvaluators);

        // Coins without value are placed back in return tray
        if (\is_null($coinValue)) {
            $this->returnTray->add($coin);
            return;
        }

        $this->pendingTransactionTray->add($coin);
        $this->displayPendingTransactionTotal();
    }

    public function selectProduct(ProductInterface $product)
    {
        foreach ($this->stock as $stock) {
            if ($stock->getProduct()->getName() == $product->getName()) {
                $availableFunds = CoinRepositoryAggregateExtensions::totalValue($this->pendingTransactionTray, $this->coinEvaluators);

                // No funds available - display price
                if ($availableFunds == 0) {
                    $this->display->setContent('PRICE '.\money_format('%i', $stock->getProduct()->getPrice()));
                    return;
                }
                
                // Product can be disposed safely
                if ($product->getPrice() <=$availableFunds) {
                    $stock->dispose();
                    $this->display->setContent('THANK YOU');
                    return;
                }
            }
        }
    }
}
