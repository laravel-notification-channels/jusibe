<?php

namespace NotificationChannels\Jusibe\Test;

class Notifiable
{
    use \Illuminate\Notifications\Notifiable;

    /**
     * @return int
     */
    public function routeNotificationForJusibe()
    {
        return '+1234567890';
    }
}
