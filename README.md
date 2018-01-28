
[![Build Status](https://travis-ci.org/cleaniquecoders/money-wrapper.svg?branch=master)](https://travis-ci.org/cleaniquecoders/money-wrapper) [![Latest Stable Version](https://poser.pugx.org/cleaniquecoders/money-wrapper/v/stable)](https://packagist.org/packages/cleaniquecoders/money-wrapper) [![Total Downloads](https://poser.pugx.org/cleaniquecoders/money-wrapper/downloads)](https://packagist.org/packages/cleaniquecoders/money-wrapper) [![License](https://poser.pugx.org/cleaniquecoders/money-wrapper/license)](https://packagist.org/packages/cleaniquecoders/money-wrapper)

## MoneyPHP Wrapper

This is a wrapper for [Money](https://github.com/moneyphp/money). 

This wrapper:

1. Provide a Money helper - `money()`
2. Intended for Laravel Framework, but can be use outside from Laravel Framework as well.
3. Provide common usage such as:

- [x] For Human Readability - RM 1.00, RM 345.00
- [x] For Common Display - 1.00, 345.00
- [x] For Machine (intended format to store in Database - integer) - 100, 34500
- [x] Fixed Exchange Rate Conversion - $ 1 > RM 3.87

## Installation

1. In order to install `cleaniquecoders/money-wrapper` in your Laravel project, just run the *composer require* command from your terminal:

```
$ composer require cleaniquecoders/money-wrapper
```

2. Then in your `config/app.php` add the following to the providers array:

```php
CleaniqueCoders\MoneyWrapper\MoneyWrapperServiceProvider::class,
```

3. In the same `config/app.php` add the following to the aliases array:

```php
'MoneyWrapper' => CleaniqueCoders\MoneyWrapper\MoneyWrapperFacade::class,
```

4. Publish Money Wrapper Config:

```
$ php artisan vendor:publish --tag=money-wrapper-config
```

> You may want to add more currency details based on country. See contributions section below for the details.

## Usage

**Get Money Wrapper Instance**

By default, MYR, Malaysia Ringgit currency will be use. 

You may override either by `.env` file or pass the country Alpha 2 code when calling `money()` helper.

```php
$money = money(); // by default it will use MY
$moneyUsd = money('US'); // pass the country code - ISO Alpha 2
```

You can add more currencies after publishing the Money Wrapper configuration file and added more supported currencies.

Please refer to [Country Code](http://www.nationsonline.org/oneworld/country_code_list.htm) and it's currency swift code and symbol in [Currency List](http://www.xe.com/iso4217.php).

**Get Money Format**

```php
echo money()->toHuman(100); // RM 1.00, useful for human readability
echo money()->toCommon(100); // 1.00
echo money()->toMachine('1.00'); // 100, always store in database as integer. 
```

**Convert Fixed Rate**

```php
$fixedExchange = [
    'MYR' => [
        'USD' => 3.87,
    ],
];
echo money()->convertFixedRate($fixedExchange, 100, 'USD')->getAmount(); // 387
```

> Recommended data type used in database is big integer

## Contributions

Updating currency list (`config/currency.php`) available based on following resources:

1. Use Country ISO Alpha 2 Code for the Key as defined in [Country List](http://www.nationsonline.org/oneworld/country_code_list.htm).
2. Refer [currency list](http://www.xe.com/iso4217.php) for the available currency.
3. Use symbol as per stated in [www.xe.com](http://www.xe.com/symbols.php).

The structure will be as following:

```php
[
	'MYR' => [
		'swift_code' => 'MYR',
		'symbol' => 'RM'
	]
]
```

## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).