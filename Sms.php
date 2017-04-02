<?php

namespace gud3\sms;

use Yii;
use yii\base\Component;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;

class Sms extends Component
{
    public $service = 'TurboSms';

    private $_client;
    private $_status;
    private $_error;
    
    public function init()
    {
        if (!$this->service) {
            throw new InvalidConfigException('No set service');
        }

        $this->_client = Yii::createObject(dirname(__DIR__). '\SmsServices\\' . $this->service);

        try {
            if ($this->_client instanceof SmsInterface) {
                $this->_client->connect(Yii::$app->params['sms']['login'], Yii::$app->params['sms']['password']);
            } else {
                throw new ErrorException('You service no implements in SmsInterface');
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
                throw new ErrorException('No send message');
            }
        } catch (ErrorException $e) {
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