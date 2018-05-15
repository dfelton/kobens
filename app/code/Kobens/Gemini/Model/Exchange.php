<?php

namespace Kobens\Gemini\Model;

class Exchange
    extends \Kobens\Core\Model\Exchange\AbstractExchange
    implements ExchangeInterface
{
    const CACHE_KEY = 'gemini';

    /**
     * @return string
     */
    public function getCacheKey()
    {
        return self::CACHE_KEY;
    }

    public function getMaxMakerBps()
    {
        return 100;
    }

    public function getMaxTakerBps()
    {
        return 100;
    }

}
