<?php

namespace gud3\sms\Services;

use gud3\sms\SmsInterface;

/**
 * Class SMSAPI
 * @package gud3\sms\Services
 */
class SMSAPI implements SmsInterface
{
    const CALL_URL = 'https://api1.smsapi.com/sms.do';
    const CALL_URL_DEBUG = 'https://api2.smsapi.com/sms.do';

    public $params;

    private $_content;
    private $_obj;
    private $_result;
    private $_status = null;

    public function connect($login, $password)
    {
        $this->params = [
            'username' => $login,
            'password' => $password,
        ];

        $this->_obj = curl_init();
        curl_setopt($this->_obj, CURLOPT_URL, self::CALL_URL);
        curl_setopt($this->_obj, CURLOPT_POST, true);
        curl_setopt($this->_obj, CURLOPT_RETURNTRANSFER, true);
    }

    public function sendSms($message)
    {
        array_push($this->params, [
            'eco' => 0,
            'message' => $message
        ]);

        curl_setopt($this->_obj, CURLOPT_POSTFIELDS, $this->params);
        $this->_content = curl_exec($this->_obj);
        $this->_result = curl_getinfo($this->_obj, CURLINFO_HTTP_CODE);

        return $this->getStatus();
    }

    public function getStatus()
    {
        if ($this->_result === 200) {
            return $this->_status = true;
        } else {
            $this->_status = false;
            curl_setopt($this->_obj, CURLOPT_URL, self::CALL_URL_DEBUG);
            $this->sendSms('Prepare response');

            throw new \ErrorException($this->_content);
        }
    }

    public function getId()
    {
        switch ($this->_status) {
            case true:
                return $this->_content;
            default:
                return null;
        }
    }
}