<?php

namespace NotificationChannels\PushCrew\Tests;

use Illuminate\Support\Arr;
use NotificationChannels\PushCrew\PushCrewMessage;

class MessageTest extends \PHPUnit_Framework_TestCase
{
    /** @var \NotificationChannels\PushCrew\PushCrewMessage */
    protected $message;

    public function setUp()
    {
        parent::setUp();
        $this->message = new PushCrewMessage();
    }

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
        $this->message->body('body');

        $this->assertEquals('body', Arr::get($this->message->toArray(), 'message'));
    }

    /** @test */
    public function it_can_set_the_subject()
    {
        $this->message->subject('subject');

        $this->assertEquals('subject', Arr::get($this->message->toArray(), 'title'));
    }

    /** @test */
    public function it_can_set_the_url()
    {
        $this->message->url('url');

        $this->assertEquals('url', Arr::get($this->message->toArray(), 'url'));
    }

    /** @test */
    public function it_can_set_the_icon()
    {
        $this->message->icon('icon');

        $this->assertEquals('icon', Arr::get($this->message->toArray(), 'image_url'));
    }
}
