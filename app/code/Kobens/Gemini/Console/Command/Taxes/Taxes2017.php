<?php

namespace Kobens\Gemini\Console\Command\Taxes;

class Taxes2017 extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var \Kobens\Gemini\Model\Taxes\Taxes2017
     */
    protected $taxes2017;

    public function __construct(
        \Kobens\Gemini\Model\Taxes\Taxes2017 $taxes2017,
        $name = 'kobens:gemini:taxes:2017'
    ) {
        $this->taxes2017 = $taxes2017;
        parent::__construct($name);
    }

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Paying up to the man');
    }

    public function execute(
        \Symfony\Component\Console\Input\InputInterface $input,
        \Symfony\Component\Console\Output\OutputInterface $output
    ) {
        $trans = $this->taxes2017->getTransactions();
        $btcBuy = $trans['buy']['BTC/USD'];
        $btcSell = $trans['sell']['BTC/USD'];
        foreach ($btcBuy as $sell) {

        }
    }
}