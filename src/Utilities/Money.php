<?php

namespace CleaniqueCoders\MoneyWrapper\Utilities;

use CleaniqueCoders\MoneyWrapper\Exceptions\CurrencyNotAvaialbleException;
use Money\Converter;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Exchange\FixedExchange;
use Money\Exchange\ReversedCurrenciesExchange;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money as MoneyPHP;
use Money\Parser\DecimalMoneyParser;

/**
 * Cast integers to MoneyPHP Instance
 * MoneyPHP only accept integer
 * @link http://moneyphp.org/en/latest/getting-started.html#accepted-integer-values
 */
class Money
{
    /**
     * Currency Configuration Used
     * @var array
     */
    protected $currency;

    /**
     * Create Static Instance
     * @param string $country
     * @return $this     static instance
     */
    public static function make(string $country = null)
    {
        if (empty($country)) {
            $country = config('default');
        }
        return (new static )->setCurrency($country);
    }

    /**
     * Set Currency
     * @param string $country
     */
    public function setCurrency($country = null)
    {
        if (is_null($country)) {
            $country = config('currency.default');
        }
        $config = config('currency.' . $country);
        if (empty($config)) {
            throw new CurrencyNotAvaialbleException($country . ' currency not avaialble.');
        }
        $this->currency = $config;
        return $this;
    }

    /**
     * Ge Current Use Currency
     * @return array
     */
    public function getCurrency()
    {
        if (!empty($this->currency)) {
            return $this->currency;
        }

        return $this->setCurrency(config('currency.default'))->getCurrency();
    }

    /**
     * Get Current Use Currency Symbol
     * @return string
     */
    public function getCurrencySymbol()
    {
        return $this->getCurrency()['symbol'];
    }

    /**
     * Get Current Use Currency Swift Code
     * @return string
     */
    public function getCurrencySwiftCode()
    {
        return $this->getCurrency()['swift_code'];
    }

    /**
     * Cast integer to MoneyPHP instance
     * @param  int $amount             amount to cast in integer format
     * @return \Money\Money        MoneyPHP Instance
     */
    public function castMoney(int $amount): MoneyPHP
    {
        return (new MoneyPHP($amount, new Currency($this->getCurrencySwiftCode())));
    }

    /**
     * Convert integer money to human readable format
     * @param  int    $amount Integer money representation
     * @return string        Return readable format for human
     */
    public function toHuman(int $amount): string
    {
        return $this->getCurrencySymbol() . ' ' . self::toCommon("{$amount}", true);
    }

    /**
     * Convert integer money to common view for the system
     * Instead of 700000, to 7000
     * @param  int    $amount Integer money representation
     * @return string        Return readable format for human
     */
    public function toCommon(int $amount, bool $format = false): string
    {
        $money          = $this->castMoney($amount, $this->getCurrencySwiftCode());
        $moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        return ($format) ?
        number_format($moneyFormatter->format($money), 2, '.', ',') :
        $moneyFormatter->format($money);
    }

    /**
     * Return to Database Format.
     * This method intended to be use before save to the database
     * and this need to be call manually.
     * @param  string    $amount
     * @param  string $swift_code
     * @return int
     */
    public function toMachine(string $amount): int
    {
        return (new DecimalMoneyParser(new ISOCurrencies()))
            ->parse(
                $amount,
                $this->getCurrencySwiftCode()
            )
            ->getAmount();
    }

    /**
     * Convert Money with given fixed rate
     * @link http://moneyphp.org/en/latest/features/currency-conversion.html#fixed-exchange
     * @param  array  $fixedExchange ['EUR' => ['USD' => 1.25]]
     * @param  int    $amount
     * @param  string $swift_code
     * @return \Money\Money
     */
    public function convertFixedRate(array $fixedExchange, int $amount, string $swift_code): MoneyPHP
    {
        return (new Converter(
            new ISOCurrencies(),
            (new ReversedCurrenciesExchange(new FixedExchange($fixedExchange)))
        ))->convert($this->castMoney($amount), new Currency($swift_code));
    }
}
