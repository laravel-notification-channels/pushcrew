<?php

namespace NotificationChannels\Engage\Exceptions;

class InvalidConfiguration extends \Exception
{
    public static function configurationNotSet()
    {
        return new static('In order to send VWO Engage Notifications you need to add your API Token to the `vwo-engage` key of `config.services`.');
    }
}
