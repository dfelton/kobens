<?php

namespace Kobens\Gemini\Api\Strategy;

interface Position
{
    const ID                    = 'entity_id';
    const STRATEGY_ID           = 'strategy_id';
    const PAIR_SYMBOL           = 'pair_symbol';
    const POSITION_OPEN_ID      = 'position_open_id';
    const POSITION_CLOSE_ID     = 'position_close_id';
    const POSITION_STATUS       = 'position_status';
    const GEMINI_OPEN_ID        = 'gemini_open_id';
    const GEMINI_CLOSE_ID       = 'gemini_close_id';
    const OPEN_CREATED_AT       = 'open_created_at';
    const OPEN_FILLED_AT        = 'open_filled_at';
    const OPEN_PRICE            = 'open_price';
    const OPEN_AMOUNT           = 'open_amount';
    const OPEN_BPS              = 'open_bps';
    const OPEN_FEE              = 'open_fee';
    const CLOSE_CREATED_AT      = 'close_created_at';
    const CLOSE_FILLED_AT       = 'close_filled_at';
    const CLOSE_PRICE           = 'close_price';
    const CLOSE_AMOUNT          = 'close_amount';
    const CLOSE_BPS             = 'close_bps';
    const CLOSE_FEE             = 'close_fee';
    const QUOTE_GAIN            = 'quote_gain';
    const BASE_GAIN             = 'base_gain';
}