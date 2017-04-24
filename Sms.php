<?php

namespace gud3\sms;

class Sms
{
    private $sender;
    private $destinations;
    private $message;

    public function __construct($sender, array $destinations, $message)
    {
        $this->sender = $sender;
        $this->destinations = $destinations;
        $this->message = $message;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function getDestinations()
    {
        return $this->destinations;
    }

    public function getMessage()
    {
        return $this->message;
    }
}