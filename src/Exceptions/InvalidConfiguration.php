<?php

namespace NotificationChannels\PushCrew\Exceptions;

class InvalidConfiguration extends \Exception
{
    public static function configurationNotSet()
    {
        return new static('In order to send PushCrew Notifications you need to add your API Token to the `pushcrew` key of `config.services`.');
    }
}
