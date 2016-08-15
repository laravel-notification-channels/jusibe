<?php

namespace NotificationChannels\Jusibe\Test;

use Mockery;
use Illuminate\Notifications\Notification;
use Orchestra\Testbench\TestCase;
use NotificationChannels\Jusibe\JusibeChannel;
use NotificationChannels\Jusibe\JusibeMessage;
use Unicodeveloper\Jusibe\Jusibe as JusibeClient;
use NotificationChannels\Jusibe\Exceptions\CouldNotSendNotification;

class JusibeChannelTest extends TestCase
{
    /** @var \Mockery\Mock */
    protected $jusibe;

    /** @var \NotificationChannels\Jusibe\JusibeChannel */
    protected $channel;

    /** @var Notification */
    protected $notification;

    /** @var JusibeMessage */
    protected $message;

    /** @var Dispatcher */
    protected $events;

    public function setUp()
    {
        parent::setUp();
        $this->jusibe = Mockery::mock(JusibeClient::class);
        $this->channel = new JusibeChannel($this->jusibe);
        $this->notification = Mockery::mock(Notification::class);
        $this->message = Mockery::mock(JusibeMessage::class);
    }

    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_can_send_a_notification()
    {
        $notifiable = new Notifiable;

        //$this->message->from = "Prosper"; need to refactor this!
        $this->notification->shouldReceive('toJusibe')
            ->with($notifiable)
            ->andReturn($this->message);


        $this->jusibe->shouldReceive('sendSMS')
            ->with(Mockery::subset([
                'to' => '+1234567890',
                'from' => 'prosper',
                'message' => 'myMessage',
            ]));

        $this->setExpectedException(CouldNotSendNotification::class);
        $this->channel->send($notifiable, $this->notification);
    }

    /** @test */
    public function it_does_not_send_a_message_when_notifiable_does_not_have_route_notificaton_for_jusibe()
    {
        $this->notification->shouldReceive('toJusibe')->never();
        $this->setExpectedException(CouldNotSendNotification::class);
        $this->channel->send(new NotifiableWithoutRouteNotificationForJusibe, $this->notification);
    }

    /** @test */
    public function it_throws_an_exception_when_it_could_not_send_the_notification()
    {
        $notifiable = new Notifiable;

        $this->notification->shouldReceive('toJusibe')
            ->with($notifiable)
            ->andReturn($this->message);

        $this->jusibe->shouldReceive('sendSMS')
            ->with(Mockery::subset([
                'to' => '+1234567890',
                'from' => 'prosper',
                'message' => 'myMessage',
            ]));
        $this->setExpectedException(CouldNotSendNotification::class);
        $this->channel->send($notifiable, $this->notification);
    }
}

class NotifiableWithoutRouteNotificationForJusibe extends Notifiable
{
    public function routeNotificationFor($channel)
    {
        return false;
    }
}
