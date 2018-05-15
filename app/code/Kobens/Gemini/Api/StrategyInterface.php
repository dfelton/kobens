<?php

namespace Kobens\Gemini\Api;

interface StrategyInterface
{
    const   MAIN_TABLE              = 'kobens_gemini_strategy';

    const   STRATEGY_ID             = 'strategy_id';
    const   IS_ACTIVE               = 'is_active';
    const   TRADING_PAIR            = 'trading_pair';
    const   STATUS                  = 'status';
    const   OPEN_PRICE              = 'open_price';
    const   OPEN_AMOUNT             = 'open_amount';
    const   OPEN_ORDER_ID           = 'open_order_id';
    const   OPEN_GEMINI_ID          = 'open_gemini_id';
    const   CLOSE_PRICE             = 'close_price';
    const   CLOSE_AMOUNT            = 'close_amount';
    const   CLOSE_ORDER_ID          = 'close_order_id';
    const   CLOSE_GEMINI_ID         = 'close_gemini_id';
}
