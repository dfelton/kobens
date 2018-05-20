<?php

namespace Kobens\Gemini\Helper;

class Data
{
    const TOP_BPS_TIER = 100;

    /**
     * Returns a flag indicating if the proposed combination of trades
     * is guaranteed to be profitable under the assumption that the
     * max trading fee will be applied to both the opening trade(s)
     * and closing trade(s) for the orders.
     *
     * @param \Kobens\Core\Model\Exchange\Pair\PairInterface $pair
     * @param number $openPrice
     * @param number $openAmount
     * @param number $closePrice
     * @param number $closeAmount
     */
    public function isPofitable(
        \Kobens\Core\Model\Exchange\Pair\PairInterface $pair,
        $openPrice,
        $openAmount,
        $closePrice,
        $closeAmount
    ) {
        \Zend_Debug::dump(\func_get_args());exit;

        $auote = $pair->getQuoteCurrency();
        $base = $pair->getBaseCurrency();
        $precision = $quote;
    }

}
