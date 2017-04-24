<?php

namespace gud3\sms\Services;

use gud3\sms\Sms;
use yii\base\InvalidConfigException;
use yii\base\Object;

class SmsAPI extends Object implements ServiceInterface
{
    public $url = 'https://api1.smsapi.com/sms.do';
    public $login;
    public $password;

    public function init()
    {
        if (empty($this->url) || empty($this->login) || empty($this->password)) {
            throw new InvalidConfigException('Specify URL, login and password.');
        }
    }

    public function send(Sms $sms)
    {
        $params = [
            'username' => $this->login,
            'password' => $this->password,
            'eco' => 0,
            'message' => [
                'from' => $sms->getSender(),
                'to' => implode(',', $sms->getDestinations()),
                'message' => $sms->getMessage(),
            ],
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        if ($status != 200) {
            throw new \RuntimeException($response);
        }

        return $response;
    }
}