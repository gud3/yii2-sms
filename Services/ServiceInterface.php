<?php

namespace gud3\sms\Services;

use gud3\sms\Sms;

/**
 * Interface ServiceInterface
 * @package gud3\sms\Services
 */
interface ServiceInterface
{
    /**
     * @param Sms $sms
     * @return mixed transaction ID
     * @throws \RuntimeException
     */
    public function send(Sms $sms);
}