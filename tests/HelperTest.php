<?php

namespace CleaniqueCoders\MoneyWrapper\Tests;

class HelperTest extends TestCase
{
    /** @test */
    public function it_has_money_helper()
    {
        $this->assertTrue(function_exists('money'));
    }

    /** @test */
    public function it_has_currency_config()
    {
        $this->assertNotNull(config('currency'));
    }

    /** @test */
    public function it_has_default_config()
    {
        $this->assertNotNull(config('currency.default'));
    }

    /** @test */
    public function it_has_currency_config_for_default_config()
    {
        $country  = config('currency.default');
        $currency = config('currency.' . $country);
        $this->assertNotNull($currency);
    }

    /** @test */
    public function it_has_currency_swift_code_config_for_default_config()
    {
        $country    = config('currency.default');
        $swift_code = config('currency.' . $country . '.swift_code');
        $this->assertEquals('MYR', $swift_code);
    }

    /** @test */
    public function it_has_currency_symbol_config_for_default_config()
    {
        $country = config('currency.default');
        $symbol  = config('currency.' . $country . '.symbol');
        $this->assertEquals('RM', $symbol);
    }

    /** @test */
    public function it_can_set_currency()
    {
        $this->assertTrue(money()->setCurrency('US') instanceof \CleaniqueCoders\MoneyWrapper\Utilities\Money);
    }

    /** @test */
    public function it_can_get_currency()
    {
        $currency = money()->getCurrency();
        $this->assertEquals(['swift_code' => 'MYR', 'symbol' => 'RM'], $currency);
    }

    /** @test */
    public function it_can_get_currency_symbol()
    {
        $symbol = money()->getCurrencySymbol();
        $this->assertEquals('RM', $symbol);
    }

    /** @test */
    public function it_can_get_currency_swift_code()
    {
        $swift_code = money()->getCurrencySwiftCode();
        $this->assertEquals('MYR', $swift_code);
    }

    /** @test */
    public function it_has_money_utility_class()
    {
        $this->assertTrue(class_exists(\CleaniqueCoders\MoneyWrapper\Utilities\Money::class));
    }

    /** @test */
    public function it_can_make_money_utility_object_for_a_country()
    {
        $this->assertNotEmpty(\CleaniqueCoders\MoneyWrapper\Utilities\Money::make('US'));
    }

    /** @test */
    public function it_can_make_money_utility_object_using_default_country()
    {
        $this->assertNotEmpty(\CleaniqueCoders\MoneyWrapper\Utilities\Money::make(config('currency.default')));
    }

    /** @test */
    public function it_can_cast_money()
    {
        $this->assertNotEmpty(money()->castMoney(100));
    }

    /** @test */
    public function it_can_cast_money_and_return_money_instance()
    {
        $this->assertTrue(money()->castMoney(100) instanceof \Money\Money);
    }

    /** @test */
    public function it_can_display_money_human_read()
    {
        $this->assertEquals('RM 1.00', money()->toHuman(100));
    }

    /** @test */
    public function it_can_display_money_common_format_use()
    {
        $this->assertEquals('1.00', money()->toCommon(100));
    }

    /** @test */
    public function it_can_display_money_database_format_use()
    {
        $this->assertEquals(100, money()->toMachine('1.00'));
    }

    /** @test */
    public function it_can_convert_based_on_fixed_rate()
    {
        $fixedExchange = [
            'MYR' => [
                'USD' => 3.87,
            ],
        ];
        $usd = money()->convertFixedRate($fixedExchange, 100, 'USD')->getAmount();
        $this->assertEquals(387, $usd);
    }
}
