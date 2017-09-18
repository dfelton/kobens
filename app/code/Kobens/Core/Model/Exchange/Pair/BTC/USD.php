<?php

namespace Kobens\Core\Model\Exchange\Pair\BTC;

class USD extends \Kobens\Core\Model\Exchange\Pair\AbstractPair
{
    public function __construct(
        \Kobens\Core\Model\Currency\Virtual\BTC $baseCurrency,
        \Kobens\Core\Model\Currency\Fiat\USD $quoteCurrency
    ) {
        parent::__construct($baseCurrency, $quoteCurrency);
    }

}
