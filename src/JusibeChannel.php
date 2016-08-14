<?php

namespace NotificationChannels\Jusibe;

use DomainException;
use Illuminate\Notifications\Notification;
use NotificationChannels\Jusibe\Exceptions\CouldNotSendNotification;
use Unicodeveloper\Jusibe\Jusibe as JusibeClient;

class JusibeChannel
{
    /**
     * The Jusibe client instance.
     *
     * @var \Jusibe\Jusibe
     */
    protected $jusibe;

    /**
     * The phone number notifications should be sent from.
     *
     * @var string
     */
    protected $from;

    /**
     * @param  JusibeClient  $jusibe
     */
    public function __construct(JusibeClient $jusibe)
    {
        $this->jusibe = $jusibe;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @return mixed
     *
     * @throws \NotificationChannels\Jusibe\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('jusibe')) {
            throw CouldNotSendNotification::missingTo();
        }

        $message = $notification->toJusibe($notifiable);

        if (is_string($message)) {
            $message = new JusibeMessage($message);
        }

        if (! $from = $message->from ?: config('services.jusibe.sms_from')) {
            throw CouldNotSendNotification::missingFrom();
        }

        try {
            $response = $this->jusibe->sendSMS([
                'to' => $to,
                'from' => $from,
                'message' => trim($message->content),
            ])->getResponse();

            return $response;
        } catch (DomainException $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        }
    }
}
