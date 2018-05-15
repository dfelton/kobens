<?php

namespace Kobens\Gemini\Model\Strategy\Source;

class OrderId
{
    /**
     * Generate an order ID
     *
     * @param \Kobens\Core\Model\Exchange\Pair\PairInterface $pair
     * @param string $bid
     * @param string $amount
     * @param string $buySell
     * @throws \Exception
     * @return string
     */
    public function generateOrderId(
        \Kobens\Core\Model\Exchange\Pair\PairInterface $pair,
        $bid,
        $amount,
        $buySell
    ) {
        if (!in_array($buySell, ['buy','sell'])) {
            throw new \Exception('Invalid buy/sell value');
        }
        if (!$bid > 0 || !is_string($bid) || !strlen($bid)) {
            throw new \Exception('Invalid bid price.');
        }
        if (!$amount > 0 || !is_string($amount) || !strlen($amount)) {
            throw new \Exception('Invalid purchase / sell amount');
        }
        return $pair->getBaseCurrency()->getMainUnitAbbreviation()
            .':'.$pair->getQuoteCurrency()->getMainUnitAbbreviation()
            .':'.$buySell
            .':'.md5(serialize([$bid,$amount]))
            .':'.number_format(microtime(true),2,'.','')
        ;
    }
}
