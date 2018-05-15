<?php

namespace Kobens\Core\Model\Exchange\Pair\BTC;

class USD extends \Kobens\Core\Model\Exchange\Pair\AbstractPair
{
    const PAIR = 'BTC/USD';

    /**
     * @param \Kobens\Core\Model\Currency\Crypto\BTC $baseCurrency
     * @param \Kobens\Core\Model\Currency\Fiat\USD $quoteCurrency
     */
    public function __construct(
        \Kobens\Core\Model\Currency\Crypto\BTC $baseCurrency,
        \Kobens\Core\Model\Currency\Fiat\USD $quoteCurrency
    ) {
        parent::__construct($baseCurrency, $quoteCurrency);
    }

}
