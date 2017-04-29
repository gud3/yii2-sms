<?php

namespace gud3\sms;

/**
 * Class Sms
 * @package gud3\sms
 */
class Sms
{
    private $sender;
    private $destinations;
    private $message;

    /**
     * Sms constructor.
     * @param $sender
     * @param array $destinations
     * @param $message
     */
    public function __construct($sender, array $destinations, $message)
    {
        $this->sender = $sender;
        $this->destinations = $destinations;
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @return array
     */
    public function getDestinations()
    {
        return $this->destinations;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }
}