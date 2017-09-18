<?php

namespace Kobens\Gemini\Console\Command\Market;

use Kobens\Core\Helper\Console\Command\StdOut\Format;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Ticker extends \Symfony\Component\Console\Command\Command
{
    const STDOUT_PREFIX = " "; // " " | "\t"
    const STDOUT_COLUMN_SEPARATOR = "  "; // " " | "\t"

    protected $columns = [
        'Lowest Ask',
        'Highest Bid',
        'Spread',
        'Last Trade',
        "          BTC",
//         "     USD",
//         "Time    ",
//         "Heartbeat"
    ];

    /**
     * @var int
     */
    protected $socketSequence = 0;

    /**
     * @var \Kobens\Gemini\Api\V1\WebSocket\MarketData\BTC\USD
     */
    protected $btcUsd;

    public function __construct(
        \Kobens\Gemini\Api\V1\WebSocket\MarketData\BTC\USD\Proxy $btcUsd,
        $name = 'kobens:gemini:market:ticker'
    ) {
        parent::__construct($name);
        $this->btcUsd = $btcUsd;
    }

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Gemini Order Book Ticker');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getHeaders());
        while (true) {
            echo self::STDOUT_PREFIX, implode(self::STDOUT_COLUMN_SEPARATOR, $this->getCurrentState()), "\r";
            usleep(500000); // 500 milliseconds
        }
    }

    protected function getHeaders()
    {
        $headers = self::STDOUT_PREFIX;
        for ($i = 0, $j = count($this->columns); $i < $j; $i++) {
            if ($i <> 0) {
                $headers .= self::STDOUT_COLUMN_SEPARATOR;
            }
            $headers .= Format::underline($this->columns[$i]);
        }
        return $headers;
    }

    protected function getCurrentState()
    {
        $askPrice = $this->btcUsd->getAskPrice();
        $bidPrice = $this->btcUsd->getBidPrice();
        $spread = $this->btcUsd->getSpread();
//         $spread = floatval(number_format($askPrice - $bidPrice, 2));
        $lastTrade = $this->btcUsd->getLastTrade();

        $columns = [
            $askPrice,
            $bidPrice,
            $spread,
            $lastTrade->getPrice(),
            $lastTrade->getQuantity(),
//             round($lastTrade['amount'] * $lastTrade['price'], 2, PHP_ROUND_HALF_UP),
//             $lastTrade['time'] ? date('H:i:s', $lastTrade['time']) : '',
//             microtime(true)
        ];
        for ($i = 0, $j = count($this->columns); $i < $j; $i++) {
            while (strlen($columns[$i]) < strlen($this->columns[$i])) {
                $columns[$i] = ' '.$columns[$i];
            }
        }
        $columns[0] = Format::red($columns[0]);
        $columns[1] = Format::green($columns[1]);
        $columns[3] = $lastTrade->getMakerSide() == 'bid' ? Format::red($columns[3]) : Format::green($columns[3]);

        return $columns;
    }
}