<?php

namespace Kobens\Gemini\Console\Command\Strategy;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @category    \Kobens
 * @package     \Kobens\Gemini
 */
class Create extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var \Kobens\Gemini\Model\ExchangeInterface
     */
    protected $exchange;

    /**
     * @var \Kobens\Gemini\Model\ResourceModel\Strategy
     */
    protected $strategyResource;

    /**
     * @var \Kobens\Gemini\Model\StrategyFactory
     */
    protected $strategyFactory;

    protected $params = [
        'pair' => null,
        'open_price' => null,
        'open_amount' => null,
        'close_price' => null,
        'close_amount' => null
    ];

    /**
     * Constructor
     *
     * @param \Kobens\Gemini\Model\ExchangeInterface $exchange
     * @param \Kobens\Gemini\Model\ResourceModel\Strategy $strategyResource
     * @param string $name
     */
    public function __construct(
        \Kobens\Gemini\Model\ExchangeInterface $exchange,
        \Kobens\Gemini\Model\ResourceModel\Strategy $strategyResource,
        \Kobens\Gemini\Model\StrategyFactory $strategyFactory,
        $name = 'kobens:gemini:strategy:create'
    ) {
        $this->exchange = $exchange;
        parent::__construct($name);
    }

    protected function configure()
    {
        parent::configure();
        $this
            ->setDescription('Create a Gemini Trading Strategy')
            ->addArgument(
                'pair',
                InputArgument::REQUIRED,
                '(Required) Currency Pair (Example: BTC/USD)'
            )
            ->addArgument(
                'open_price',
                InputArgument::REQUIRED,
                '(Required) Open Price (Example: 10000)'
            )
            ->addArgument(
                'open_amount',
                InputArgument::REQUIRED,
                '(Required) Open Amount (Example: 1.00000002)'
            )
            ->addArgument(
                'close_price',
                InputArgument::REQUIRED,
                '(Required) Close Price (Example: 11000)'
            )
            ->addArgument(
                'close_amount',
                InputArgument::OPTIONAL,
                '(Required) Close Amount (Example: 1.00000001)'
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->params['pair'] = $this->exchange->getPair($input->getArgument('pair'));
        $this->params['open_price'] = $input->getArgument('open_price');
        $this->params['open_amount'] = $input->getArgument('open_amount');
        $this->params['close_price'] = $input->getArgument('close_price');
        $this->params['close_amount'] = $input->getArgument('close_amount');
        $this->validateParams();
    }

    /**
     * Validates the parameters passed to the CLI command
     *
     * @throws \Exception
     */
    protected function validateParams()
    {
        throw new \Exception('TODO: '.__METHOD__);
    }

}
