<?php

namespace app\code\Kobens\Gemini\Model;

use Magento\Framework\Model\AbstractModel;

class Strategy extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Kobens\Gemini\Model\ResourceModel\Strategy');
    }
}

