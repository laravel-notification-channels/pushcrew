<?php

namespace NotificationChannels\PushCrew;

use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;
use NotificationChannels\PushCrew\Exceptions\InvalidConfiguration;
use NotificationChannels\PushCrew\Exceptions\CouldNotSendNotification;

class PushCrewChannel
{
    const API_ENDPOINT = 'https://pushcrew.com/api/v1/send/list';

    /** @var \GuzzleHttp\Client */
    protected $client;

    /**
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\PushCrew\Exceptions\InvalidConfiguration
     * @throws \NotificationChannels\PushCrew\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $subscribers = collect($notifiable->routeNotificationFor('PushCrew'));

        if (! $subscribers->count()) {
            return;
        }

        if (! $token = config('services.pushcrew.token')) {
            throw InvalidConfiguration::configurationNotSet();
        }

        $message = $notification->toPushCrew($notifiable);

        $data = $message->toArray() + [
            'subscriber_list' => json_encode([
                'subscriber_list' => $subscribers,
            ]),
        ];

        $response = $this->client->post(self::API_ENDPOINT, [
            'headers' => ['Authorization' => $token],
            'http_errors' => false,
            'form_params' => $data,
        ]);

        if ($response->getStatusCode() !== 200) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
        }
    }
}
