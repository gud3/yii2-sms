<?php

namespace gud3\sms;

interface SmsInterface 
{
    public function connect($login, $password);

    public function sendSms($message);

    public function getStatus();

    public function getId();
}