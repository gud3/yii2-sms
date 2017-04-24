<?php

namespace gud3\sms\Services;

use gud3\sms\Sms;
use SoapClient;
use yii\base\InvalidConfigException;
use yii\base\Object;

class TurboSms extends Object implements ServiceInterface
{
    public $url = 'http://turbosms.in.ua/api/wsdl.html';
    public $login;
    public $password;

    public function init()
    {
        if (empty($this->url) || empty($this->login) || empty($this->password)) {
            throw new InvalidConfigException('Specify URL, login and password.');
        }
    }

    private $_client;

    public function send(Sms $sms)
    {
        $result = $this->getClient()->SendSMS([
            'sender' => $sms->getSender(),
            'destination' => implode(',', $sms->getDestinations()),
            'text' => $sms->getMessage()
        ]);

        $status = $result->SendSMSResult->ResultArray[0];
        if ($status !== 'Сообщения успешно отправлены') {
            throw new \RuntimeException($status);
        }

        return $result->SendSMSResult->ResultArray[1];
    }

    private function getClient()
    {
        if ($this->_client === null) {
            $client = new SoapClient($this->url);
            $result = $client->Auth([
                'login' => $this->login,
                'password' => $this->password,
            ]);
            if ($result->AuthResult !== 'Вы успешно авторизировались') {
                throw new \RuntimeException($result->AuthResult);
            }
            $this->_client = $client;
        }
        return $this->_client;
    }
}