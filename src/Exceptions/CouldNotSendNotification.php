<?php

namespace NotificationChannels\PushCrew\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($response)
    {
        return new static("PushCrew responded with an error: {$response->getStatusCode()} {$response->getReasonPhrase()} - {$response->getBody()}");
    }
}
