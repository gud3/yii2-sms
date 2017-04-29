<?php

namespace gud3\sms;

use gud3\sms\Services\ServiceInterface;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\di\Instance;

/**
 * Class Client
 * @package gud3\sms
 */
class Client extends Component
{
    /**
     * @var string|ServiceInterface
     */
    public $service;
    /**
     * @var string Sender name
     */
    public $sender;

    public function init()
    {
        if (empty($this->sender)) {
            throw new InvalidConfigException('Specify sender name.');
        }
        $this->service = Instance::ensure($this->service, 'gud3\sms\Services\ServiceInterface');
    }

    /**
     * @param string|array $to
     * @param string $message
     * @return mixed transaction ID
     * @throws \RuntimeException
     */
    public function send($to, $message)
    {
        return $this->service->send(new Sms($this->sender, (array)$to, $message));
    }
}