<?php

namespace NotificationChannels\PushCrew\Tests;

use Mockery;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\TestCase;
use NotificationChannels\PushCrew\PushCrewChannel;
use NotificationChannels\PushCrew\PushCrewMessage;
use NotificationChannels\PushCrew\Exceptions\InvalidConfiguration;
use NotificationChannels\PushCrew\Exceptions\CouldNotSendNotification;

class ChannelTest extends TestCase
{
    /** @test */
    public function it_can_send_a_notification()
    {
        $this->app['config']->set('services.pushcrew.token', 'secret-token');

        $client = Mockery::mock(Client::class);
        $response = new Response(200);

        $client->shouldReceive('post')
            ->once()
            ->with('https://pushcrew.com/api/v1/send/list', [
                'headers' => [
                    'Authorization' => 'secret-token',
                ],
                'http_errors' => false,
                'form_params' => [
                    'url' => 'url',
                    'title' => 'subject',
                    'message' => 'body',
                    'image_url' => 'icon',
                    'subscriber_list' => json_encode([
                        'subscriber_list' => [
                            'subscriber_1',
                            'subscriber_2',
                        ],
                    ]),
                ],
            ])
            ->andReturn($response);

        $channel = new PushCrewChannel($client);
        $channel->send(new TestNotifiable, new TestNotification);
    }
    /** @test */
    public function it_does_not_send_a_notification_without_subscribers()
    {
        $this->app['config']->set('services.pushcrew.token', 'secret-token');

        $client = Mockery::mock(Client::class);

        $client->shouldReceive('post')
            ->never();

        $channel = new PushCrewChannel($client);
        $channel->send(new TestNotifiableWithoutSubscribers, new TestNotification);
    }

    /** @test */
    public function it_throws_an_exception_when_it_is_not_configured()
    {
        $this->setExpectedException(InvalidConfiguration::class);

        $channel = new PushCrewChannel(new Client);
        $channel->send(new TestNotifiable, new TestNotification);
    }

    /** @test */
    public function it_throws_an_exception_when_it_could_not_send_the_notification()
    {
        $this->app['config']->set('services.pushcrew.token', 'secret-token');

        $client = Mockery::mock(Client::class);
        $response = new Response(400);

        $client->shouldReceive('post')
            ->once()
            ->andReturn($response);

        $this->setExpectedException(CouldNotSendNotification::class);

        $channel = new PushCrewChannel($client);
        $channel->send(new TestNotifiable, new TestNotification);
    }
}

class TestNotifiable
{
    use \Illuminate\Notifications\Notifiable;

    public function routeNotificationForPushCrew()
    {
        return [
            'subscriber_1',
            'subscriber_2',
        ];
    }
}

class TestNotifiableWithoutSubscribers
{
    use \Illuminate\Notifications\Notifiable;

    public function routeNotificationForPushCrew()
    {
        return [];
    }
}

class TestNotification extends \Illuminate\Notifications\Notification
{
    public function toPushCrew()
    {
        return (new PushCrewMessage)
            ->subject('subject')
            ->icon('icon')
            ->body('body')
            ->url('url');
    }
}
