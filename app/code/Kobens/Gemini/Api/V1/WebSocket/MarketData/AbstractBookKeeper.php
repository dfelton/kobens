<?php

namespace Kobens\Gemini\Api\V1\WebSocket\MarketData;

abstract class AbstractBookKeeper extends \Kobens\Core\Model\Exchange\Book\Keeper\AbstractKeeper
{
    const WEBSOCKET_URL = 'wss://api.gemini.com/v1/marketdata/:pair';

    /**
     * @var string
     */
    protected $websocketUrl;

    /**
     * @var int
     */
    protected $socketSequence;

    /**
     * @return string
     */
    protected function getWebSocketUrl()
    {
        if (!$this->websocketUrl) {
            $pair =
                $this->getBaseCurrency()->getPairIdentity() .
                $this->getQuoteCurrency()->getPairIdentity()
            ;
            $this->websocketUrl = str_replace(':pair', $pair, self::WEBSOCKET_URL);
        }
        return $this->websocketUrl;
    }

    public function openBook()
    {
        $this->socketSequence = 0;
        $loop = \React\EventLoop\Factory::create();
        $connector = new \Ratchet\Client\Connector($loop);
        $connector($this->getWebSocketUrl())->then(
            function(\Ratchet\Client\WebSocket $conn) {
                $conn->on('message', function(\Ratchet\RFC6455\Messaging\MessageInterface $msg) use ($conn) {
                    $msg = json_decode($msg);
                    if ($msg->socket_sequence == 0) {
                        $this->populateBook($msg->events);
                    } else {
                        if ($this->socketSequence <> $msg->socket_sequence-1) {
                            $conn->close(1000, 'Non-sequential socket squence detected, reconnecting...');
                            return;
                        }
                        $this->socketSequence = $msg->socket_sequence;

                        switch ($msg->type) {
                            case 'heartbeat':
                                break;

                            case 'update':
                                $this->processEvents($msg->events, $msg->timestampms);
                                break;

                            default:
                                throw new \Exception ('Unhandled Message Type: '.$msg->type."\n");
                                break;
                        }

                    }
                });
                $conn->on('close', function($code = null, $reason = null) {
                    $this->openBook();
                });
            },
            function(\Exception $e) use ($loop) {
                $loop->stop();
            }
        );
        $loop->run();
    }

    protected function populateBook(array $events)
    {
        if ($events[0]->reason !== 'initial') {
            throw new \Exception('Book can only be populated with initial event set');
        }
        $book = [
            'bid' => [],
            'ask' => []
        ];
        foreach ($events as $event) {
            $book[$event->side][(string) $event->price] = floatval($event->remaining);
        }
        parent::populateBook($book);
    }

    /**
     * @param array $events
     * @param decimal $timestampms
     */
    protected function processEvents(array $events, $timestampms)
    {
        foreach ($events as $event) {
            switch ($event->type) {
                case 'change':
                    $this->updateBook($event->side, $event->price, floatval($event->remaining));
                    break;
                case 'trade':
                    if (in_array($event->makerSide, ['bid','ask'])) {
                        $this->setLastTrade(new \Kobens\Core\Model\Exchange\Book\Trade\Trade(
                            $event->makerSide,
                            $event->amount,
                            $event->price,
                            $timestampms
                        ));
                    }
                    break;

                case 'auction_indicative':
                default:
                    break;
            }
        }
    }
}
