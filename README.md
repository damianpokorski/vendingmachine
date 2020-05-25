# Readme

A simple vending machine logic implemented with TDD and SOLID approach in mind

## Project set up
I think these are fairly standard but it is always better to have a nice guide on what is intended to get the project running

### Pull the repo
```bash
git clone damianpokorski/vendingmachine
```

### Download packages
```bash
composer install
```

### Run unit tests
You can either just call the PHPUnit binary directly
```bash
vendor/bin/phpunit
```
Or use the executable task within the composer.json 
```bash
composer run-script test
```

Here's up to date output

```

PHPUnit Pretty Result Printer 0.27.0 by Codedungeon and contributors.
'==> Configuration: '~/projectsetup/vendor/codedungeon/phpunit-result-printer/src/phpunit-printer.yml

PHPUnit 9.1.5 by Sebastian Bergmann and contributors.

Runtime:       PHP 7.3.17-1+ubuntu18.04.1+deb.sury.org+1 with Xdebug 2.9.3
Configuration: /home/d/projectsetup/phpunit.xml


 ==> AcceptCoinFeature          ✔  ✔  ✔  
 ==> DisplayFeature             ✔  ✔  
 ==> ExactChangeOnlyFeature     ✔  
 ==> MakeChangeFeature          ✔  
 ==> ReturnCoinsFeature         ✔  
 ==> SelectProductFeature       ✔  ✔  ✔  ✔  
 ==> SoldOutFeature             ✔  ✔  
 ==> ...gregateExtensionsTest   ✔  ✔  
 ==> CoinTest                   ✔  ✔  ✔  ✔  
 ==> MemoryCoinRepositoryTest   ✔  ✔  ✔  
 ==> MemoryDisplayTest          ✔  ✔  
 ==> ProductTest                ✔  ✔  ✔  
 ==> StockTest                  ✔  ✔  ✔  
 ==> VendingMachineTest         ✔  

Time: 00:00.078, Memory: 8.00 MB

OK (32 tests, 63 assertions)
```

### Coverage tests
In order to run a coverage tests you can use

```bash
vendor/bin/phpunit --coverage-text
```

```bash
composer run-script test
```

Here's the up to date output
```
PHPUnit 9.1.5 by Sebastian Bergmann and contributors.

Runtime:       PHP 7.3.17-1+ubuntu18.04.1+deb.sury.org+1 with Xdebug 2.9.3
Configuration: /home/d/projectsetup/phpunit.xml

................................                                  32 / 32 (100%)

Time: 00:00.202, Memory: 8.00 MB

OK (32 tests, 63 assertions)


Code Coverage Report:       
  2020-05-25 00:27:33       
                            
 Summary:                   
  Classes: 100.00% (19/19)  
  Methods: 100.00% (47/47)  
  Lines:   100.00% (150/150)

VendingMachine\CoinRepository\CoinRepositoryAggregateExtensions
  Methods: 100.00% ( 1/ 1)   Lines: 100.00% (  5/  5)
VendingMachine\CoinRepository\MemoryCoinRepository
  Methods: 100.00% ( 3/ 3)   Lines: 100.00% (  6/  6)
VendingMachine\Coin\Coin
  Methods: 100.00% ( 3/ 3)   Lines: 100.00% (  5/  5)
VendingMachine\Coin\CoinExtensions
  Methods: 100.00% ( 1/ 1)   Lines: 100.00% (  4/  4)
VendingMachine\Coin\Definition\DimeCoin
  Methods: 100.00% ( 2/ 2)   Lines: 100.00% (  2/  2)
VendingMachine\Coin\Definition\NickelCoin
  Methods: 100.00% ( 2/ 2)   Lines: 100.00% (  2/  2)
VendingMachine\Coin\Definition\QuarterCoin
  Methods: 100.00% ( 2/ 2)   Lines: 100.00% (  2/  2)
VendingMachine\Coin\Evaluator\CommonEvaluators
  Methods: 100.00% ( 1/ 1)   Lines: 100.00% (  3/  3)
VendingMachine\Coin\Evaluator\DimeCoinEvaluator
  Methods: 100.00% ( 3/ 3)   Lines: 100.00% (  3/  3)
VendingMachine\Coin\Evaluator\NickelCoinEvaluator
  Methods: 100.00% ( 3/ 3)   Lines: 100.00% (  3/  3)
VendingMachine\Coin\Evaluator\QuarterCoinEvaluator
  Methods: 100.00% ( 3/ 3)   Lines: 100.00% (  3/  3)
VendingMachine\Display\MemoryDisplay
  Methods: 100.00% ( 2/ 2)   Lines: 100.00% ( 10/ 10)
VendingMachine\SimpleVendingMachine
  Methods: 100.00% ( 1/ 1)   Lines: 100.00% (  9/  9)
VendingMachine\Stock\Definition\CandyProduct
  Methods: 100.00% ( 2/ 2)   Lines: 100.00% (  2/  2)
VendingMachine\Stock\Definition\ChipsProduct
  Methods: 100.00% ( 2/ 2)   Lines: 100.00% (  2/  2)
VendingMachine\Stock\Definition\CokeProduct
  Methods: 100.00% ( 2/ 2)   Lines: 100.00% (  2/  2)
VendingMachine\Stock\MemoryStock
  Methods: 100.00% ( 4/ 4)   Lines: 100.00% (  7/  7)
VendingMachine\Stock\Product
  Methods: 100.00% ( 3/ 3)   Lines: 100.00% (  5/  5)
VendingMachine\VendingMachine
  Methods: 100.00% ( 7/ 7)   Lines: 100.00% ( 75/ 75)
```

### Notes

This tech challange was actually quite fun, took me probably between 2 - 3 hours total due to unlucky ongoing distractions from social media... oh well.