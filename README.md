## About Your Package

Tell people about your package

## Installation

1. In order to install `cleanique-coders/money-wrapper` in your Laravel project, just run the *composer require* command from your terminal:

```
composer require cleanique-coders/money-wrapper
```

2. Then in your `config/app.php` add the following to the providers array:

```php
CleaniqueCoders\MoneyWrapper\MoneyWrapperServiceProvider::class,
```

3. In the same `config/app.php` add the following to the aliases array:

```php
'MoneyWrapper' => CleaniqueCoders\MoneyWrapper\MoneyWrapperFacade::class,
```

## Usage

## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).