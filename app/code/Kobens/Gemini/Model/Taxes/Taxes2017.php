<?php

namespace Kobens\Gemini\Model\Taxes;

use function Magento\Setup\Model\Cron\is_resource;

class Taxes2017
{
    /**
     * @var array
     */
    protected $rawData = [];

    /**
     * @var resource
     */
    protected $handle;

    /**
     * @var \Magento\Framework\Filesystem\DirectoryList
     */
    protected $dirList;

    /**
     * @var array
     */
    protected $transactions = [];

    /**
     * @param \Magento\Framework\Filesystem\DirectoryList $dirList
     */
    public function __construct(
        \Magento\Framework\Filesystem\DirectoryList $dirList
    ) {
        $this->dirList = $dirList;
    }

    protected function initBuySellData()
    {
        $data = [];
        foreach ($this->getTransactions() as $transaction) {


        }
    }

    /**
     *
     */
    public function getTransactions()
    {
        if (!$this->transactions) {
            $headers = $this->getRawData()[0];
            $rawData = $this->getRawData();
            $data = [];
            unset($rawData[0]);
            foreach ($rawData as $row) {
                foreach ($headers as $i => $label) {
                    $row[$label] = $row[$i];
                    unset($row[$i]);
                }

                if (in_array($row['Type'], ['Buy','Sell'])) {
                    $type = strtolower($row['Type']);
                    if (!isset($data[$type])) {
                        $data[$type] = [];
                    }
                    if ($row['Symbol'] == 'BTCUSD') {
                        $pair = \Kobens\Core\Model\Exchange\Pair\BTC\USD::PAIR;
                    } elseif ($row['Symbol'] == 'ETHUSD') {
                        $pair = \Kobens\Core\Model\Exchange\Pair\ETH\USD::PAIR;
                    } else {
                        throw new Exception ('Unhandled Gemini Pair');
                    }
                    if (!isset($data[$type][$pair])) {
                        $data[$type][$pair] = [];
                    }
                    $data[$type][$pair][] = $row;
                }

            }
            $this->transactions = $data;
        }
        return $this->transactions;
    }

    /**
     *
     * @throws Exception
     * @return array
     */
    protected function getRawData()
    {
        if (!$this->rawData) {
            $this->rawData = [];
            while (false !== $row = fgetcsv($this->getHandle())) {
                $this->rawData[] = $row;
            }
            if (!$this->rawData) {
                throw new Exception('Unable to retrieve transaction data from CSV file.');
            }
            $this->closeHandle();
        }
        return $this->rawData;
    }

    protected function getHandle()
    {
        if (!$this->handle) {
            $varDir = $this->dirList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR);
            $filename = $varDir . DIRECTORY_SEPARATOR . 'gemini.csv';
            $handle = fopen($filename, 'r');
            if (!\is_resource($handle)) {
                throw new Exception ('Missing Import File');
            }
            $this->handle = $handle;
        }
        return $this->handle;
    }

    protected function closeHandle()
    {
        if (\is_resource($this->handle)) {
            fclose($this->handle);
            $this->handle = null;
        }
        return $this;
    }
}