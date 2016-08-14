<?php

namespace NotificationChannels\Jusibe\Test;

use NotificationChannels\Jusibe\JusibeMessage;
use PHPUnit_Framework_TestCase;

class JusibeMessageTest extends PHPUnit_Framework_TestCase
{
    /** @var \NotificationChannels\Jusibe\JusibeMessage */
    protected $message;

    public function setUp()
    {
        parent::setUp();
        $this->message = new JusibeMessage();
    }

    /** @test */
    public function it_can_accept_a_message_when_constructing_a_message()
    {
        $message = new JusibeMessage('myMessage');
        $this->assertEquals('myMessage', $message->content);
    }

    /** @test */
    public function it_can_set_the_content()
    {
        $this->message->content('myMessage');
        $this->assertEquals('myMessage', $this->message->content);
    }

    /** @test */
    public function it_can_set_the_from()
    {
        $this->message->from('+1234567890');
        $this->assertEquals('+1234567890', $this->message->from);
    }
}
