<?php

namespace gud3\sms\Services;

use Yii;
use yii\base\ErrorException;
use SoapClient;
use gud3\sms\SmsInterface;

class TurboSms implements SmsInterface
{
    const CALL_URL = 'http://turbosms.in.ua/api/wsdl.html';
    
    private $_obj;
    private $_result;
    private $_status = null;

    public function connect($login, $password)
    {
        $this->_obj = new SoapClient(self::CALL_URL);

        $result = $this->_obj->Auth([
            'login' => $login,
            'password' => $password,
        ]);

        if ($result->AuthResult !== 'Вы успешно авторизировались') {
            throw new ErrorException($result->AuthResult);
        }
    }

    public function sendSms($message)
    {
        $this->_result = $this->_obj->SendSMS($message);
    }

    public function getStatus()
    {
        $out_status = $this->_result->SendSMSResult->ResultArray[0];
        if ($out_status == 'Сообщения успешно отправлены') {
            $this->_status = true;

            return true;
        } else {
            return $out_status;
        }
    }

    public function getId()
    {
        switch ($this->_status) {
            case true:
                return $this->_status->SendSMSResult->ResultArray[1];
            default:
                return null;
        }
    }
}