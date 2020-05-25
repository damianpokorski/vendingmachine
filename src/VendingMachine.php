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
            $this->displayDefaultMessage();
        }

        // Set arbitratry math precition to 3 digits after .
        bcscale(3);
    }

    private function displayPendingTransactionTotal()
    {
        $totalValue = CoinRepositoryAggregateExtensions::totalValue($this->pendingTransactionTray, $this->coinEvaluators);
        $this->display->setContent(\money_format('%i', $totalValue));
    }

    private function displayDefaultMessage()
    {
        $changeAvailable = true;

        // If the bank is empty - EXACT CHANGE ONLY
        if (empty($this->bank->contents())) {
            $changeAvailable = false;
        }

        // Check if we have at least a sinle coin of each type that we accept
        foreach ($this->coinEvaluators as $evaluator) {
            if ($this->pickChange($evaluator->getValue()) == null) {
                $changeAvailable = false;
                break;
            }
        }

        $this->display->setContent($changeAvailable ? 'INSERT COIN' : 'EXACT CHANGE ONLY');
    }

    public function pickChange($changeToDispose)
    {
        $evaluators = $this->coinEvaluators;

        // Only look at the coins with value which is equal or less of the change to dispose
        $availableCoins = array_filter($this->bank->contents(), function (CoinInterface $coin) use ($changeToDispose, $evaluators) {
            return CoinExtensions::getCoinValue($coin, $evaluators) <= $changeToDispose;
        });
        
        // Sort available coins by their value - desc
        \usort($availableCoins, function (CoinInterface $a, CoinInterface $b) use ($evaluators) {
            return CoinExtensions::getCoinValue($a, $evaluators) < CoinExtensions::getCoinValue($b, $evaluators) ? 1 : -1;
        });

        // Using bccomp function instead of >= as floating point comparisons cannot be trusted
        // Same reason bcsub is used instead of -
        // And bcadd instead of +

        $change = [];
        $changeValue = "0.0";
        
        // Iterate through the coins in the bank
        foreach ($availableCoins as $coin) {
            // Calculate remaining change to pay
            $outstandingChange = $changeToDispose - $changeValue;
            $coinValue = CoinExtensions::getCoinValue($coin, $evaluators);

            // If coin can contribute to the change without going overpaying the customer - use it
            if (bccomp($outstandingChange, $coinValue) == 1 || bccomp($outstandingChange, $coinValue) == 0) {
                // Update change
                $change[] = $coin;
                $changeValue = bcadd($changeValue, $coinValue);

                // Recaulculate outstanding change as it has been changed
                $outstandingChange = bcsub($changeToDispose, $changeValue);
            }

            // No more outstanding change to process
            if (bccomp($outstandingChange, 0) == 0) {
                return $change;
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
                // If there is no stock available - abandon the process after updating temporary message
                if ($stock->getQuantity() < 1) {
                    $this->display->setContent('SOLD OUT', true);
                    return;
                }

                $availableFunds = CoinRepositoryAggregateExtensions::totalValue($this->pendingTransactionTray, $this->coinEvaluators);

                // No funds available - display price
                if ($availableFunds < $product->getPrice()) {
                    $this->displayDefaultMessage();
                    $this->display->setContent('PRICE '.\money_format('%i', $stock->getProduct()->getPrice()), true);
                    return;
                }
                
                // Product can be disposed safely
                if ($product->getPrice() <=$availableFunds) {
                    // Calculate and see if the change can be disposed
                    $changeToDispose = bcsub($availableFunds, $product->getPrice());

                    if (bccomp($changeToDispose, 0) == 1) {
                        $preparedChange = $this->pickChange($changeToDispose);
                        
                        // Move change to the tray
                        foreach ($preparedChange as $coin) {
                            $this->returnTray->add($coin);
                        }
                    }

                    // Move the coins from pending tray to the bank
                    foreach ($this->pendingTransactionTray->contents() as $coin) {
                        $this->pendingTransactionTray->remove($coin);
                        $this->bank->add($coin);
                    }

                    // Dispose items
                    $stock->dispose();

                    // Update display
                    $this->displayDefaultMessage();
                    $this->display->setContent('THANK YOU', true);
                    return;
                }
            }
        }
    }

    public function returnCoins()
    {
        foreach ($this->pendingTransactionTray->contents() as $coin) {
            $this->pendingTransactionTray->remove($coin);
            $this->returnTray->add($coin);
        }
        $this->displayDefaultMessage();
    }
}
