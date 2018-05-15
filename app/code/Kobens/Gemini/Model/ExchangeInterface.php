<?php

namespace Kobens\Gemini\Model;

interface ExchangeInterface extends \Kobens\Core\Model\Exchange\ExchangeInterface
{
    public function getMaxMakerBps();

    public function getMaxTakerBps();
}

