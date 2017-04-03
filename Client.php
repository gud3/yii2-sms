<?php

namespace gud3\sms;

use Yii;
use yii\base\Component;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;

class Client extends Component
{
    public $service = 'TurboSms';
    public $name;
    public $login;
    public $password;

    private $_client;
    private $_status;
    private $_error;
    
    public function init()
    {
        if (!$this->service) {
            throw new InvalidConfigException('No set service');
        }

        try {
            $this->_client = Yii::createObject('gud3\sms\Services\\' . $this->service);

            if ($this->_client instanceof SmsInterface) {
                $this->_client->connect($this->login, $this->password);
            } else {
                throw new \Exception('You service no implements in SmsInterface');
            }
        } catch (ErrorException $e) {
            $this->_error = $e->getMessage();
            $this->_status = false;
        }
    }

    public function send($destination, $message)
    {
        if ($this->_error){
            return $this->_error;
        }

        // Prepare SMS message
        $sms = [
            'sender' => Yii::$app->params['sms']['name'],
            'destination' => implode(',', (array) $destination),
            'text' => $message
        ];

        try {
            // Send message
            $this->_client->sendSMS($sms);

            if ($this->_client->getStatus() === true) {
                $this->_status = $this->_client->getId();
            } else {
                throw new \Exception('No send message');
            }
        } catch (\ErrorException $e) {
            $this->_error = $e->getMessage();
            $this->_status = false;
        }

        return $this->_status;
    }

    public function getStatus()
    {
        return $this->_error;
    }

    public function getError()
    {
        return $this->_error;
    }

}