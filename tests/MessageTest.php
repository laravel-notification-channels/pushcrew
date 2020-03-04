<?php

namespace NotificationChannels\Engage\Tests;

use Illuminate\Support\Arr;
use NotificationChannels\Engage\EngageMessage;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    /** @test */
    public function it_can_accept_a_message_when_constructing_a_message()
    {
        $message = new EngageMessage('body');

        $this->assertEquals('body', Arr::get($message->toArray(), 'message'));
    }

    /** @test */
    public function it_provides_a_create_method()
    {
        $message = EngageMessage::create('body');

        $this->assertEquals('body', Arr::get($message->toArray(), 'message'));
    }

    /** @test */
    public function it_can_set_the_body()
    {
        $message = new EngageMessage;

        $message->body('body');

        $this->assertEquals('body', Arr::get($message->toArray(), 'message'));
    }

    /** @test */
    public function it_can_set_the_subject()
    {
        $message = new EngageMessage;

        $message->subject('subject');

        $this->assertEquals('subject', Arr::get($message->toArray(), 'title'));
    }

    /** @test */
    public function it_can_set_the_url()
    {
        $message = new EngageMessage;

        $message->url('url');

        $this->assertEquals('url', Arr::get($message->toArray(), 'url'));
    }

    /** @test */
    public function it_can_set_the_icon()
    {
        $message = new EngageMessage;

        $message->icon('icon');

        $this->assertEquals('icon', Arr::get($message->toArray(), 'image_url'));
    }
}
