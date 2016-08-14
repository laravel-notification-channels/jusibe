<?php

namespace NotificationChannels\Jusibe\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function configurationNotSet()
    {
        return new static(
            "In order to send notification via Jusibe you need to add credentials in the `jusibe` key of `config.services`.");
    }
}
