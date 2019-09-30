<?php

namespace NotificationChannels\Engage\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($response)
    {
        return new static("VWO Engage responded with an error: {$response->getStatusCode()} {$response->getReasonPhrase()} - {$response->getBody()}");
    }
}
