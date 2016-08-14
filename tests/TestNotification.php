<?php

namespace NotificationChannels\Jusibe\Test;

use Illuminate\Notifications\Notification;
use NotificationChannels\Jusibe\JusibeMessage;

class TestNotification extends Notification
{
    public function toJusibe($notifiable)
    {
        return (new JusibeMessage)
                ->content('myMessage')
                ->from('+1234567890');
    }
}
