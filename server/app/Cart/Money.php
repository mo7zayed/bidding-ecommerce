<?php

namespace App\Cart;

use Money\Currency;
use Money\Money as BaseMoney;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use NumberFormatter;

class Money
{
    /**
     * The base money php instance.
     *
     * @var BaseMoney
     */
    private $money;

    /**
     * Instanciate the custom money class.
     *
     * @param string|int $money
     */
    public function __construct($money)
    {
        $this->money = new BaseMoney($money, new Currency("USD"));
    }

    /**
     * Get the formatted price.
     *
     * @return string
     */
    public function formatted() : string
    {
        $formatter = new IntlMoneyFormatter(
            new NumberFormatter("en_GB", NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );

        return $formatter->format($this->money);
    }

    /**
     * Get amount of the money.
     *
     * @return string
     */
    public function amount() : string
    {
        return $this->money->getAmount();
    }
}
