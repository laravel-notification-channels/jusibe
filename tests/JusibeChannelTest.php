<?php

namespace NotificationChannels\OneSignal\Test;

use Mockery;
use GuzzleHttp\Psr7\Response;
use NotificationChannels\Jusibe\Test\Notifiable;
use NotificationChannels\Jusibe\Test\TestNotification;
use Orchestra\Testbench\TestCase;
use NotificationChannels\Jusibe\JusibeChannel;
use Unicodeveloper\Jusibe\Jusibe as JusibeClient;
use NotificationChannels\Jusibe\Exceptions\CouldNotSendNotification;

class JusibeChannelTest extends TestCase
{
    /** @var \Mockery\Mock */
    protected $jusibe;

    /** @var \NotificationChannels\Jusibe\JusibeChannel */
    protected $channel;

    public function setUp()
    {
        parent::setUp();
        $this->jusibe = Mockery::mock(JusibeClient::class);
        $this->channel = new JusibeChannel($this->jusibe);
    }

    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_can_send_a_notification()
    {
        $response = new Response(200);
        $this->jusibe->shouldReceive('sendSMS')
            ->once()
            ->with([
                'to' => '+1234567890',
                'from' => 'prosper',
                'message' => 'myMessage',
            ])
            ->andReturn($response);
        $this->channel->send(new Notifiable(), new TestNotification());
    }

    /** @test */
    public function it_throws_an_exception_when_it_could_not_send_the_notification()
    {
        $response = new Response(500, [], 'ResponseBody');
        $this->jusibe->shouldReceive('sendSMS')
            ->once()
            ->with([
                'to' => '+1234567890',
                'from' => 'prosper',
                'message' => 'myMessage',
            ])
            ->andReturn($response);
        $this->setExpectedException(CouldNotSendNotification::class);
        $this->channel->send(new Notifiable(), new TestNotification());
    }
}
