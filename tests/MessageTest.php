<?php

namespace NotificationChannels\PushCrew\Tests;

use Illuminate\Support\Arr;
use PHPUnit\Framework\TestCase;
use NotificationChannels\PushCrew\PushCrewMessage;

class MessageTest extends TestCase
{
    /** @test */
    public function it_can_accept_a_message_when_constructing_a_message()
    {
        $message = new PushCrewMessage('body');

        $this->assertEquals('body', Arr::get($message->toArray(), 'message'));
    }

    /** @test */
    public function it_provides_a_create_method()
    {
        $message = PushCrewMessage::create('body');

        $this->assertEquals('body', Arr::get($message->toArray(), 'message'));
    }

    /** @test */
    public function it_can_set_the_body()
    {
        $message = new PushCrewMessage;

        $message->body('body');

        $this->assertEquals('body', Arr::get($message->toArray(), 'message'));
    }

    /** @test */
    public function it_can_set_the_subject()
    {
        $message = new PushCrewMessage;

        $message->subject('subject');

        $this->assertEquals('subject', Arr::get($message->toArray(), 'title'));
    }

    /** @test */
    public function it_can_set_the_url()
    {
        $message = new PushCrewMessage;

        $message->url('url');

        $this->assertEquals('url', Arr::get($message->toArray(), 'url'));
    }

    /** @test */
    public function it_can_set_the_icon()
    {
        $message = new PushCrewMessage;

        $message->icon('icon');

        $this->assertEquals('icon', Arr::get($message->toArray(), 'image_url'));
    }
}
