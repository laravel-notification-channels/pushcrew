<?php

namespace NotificationChannels\Engage;

use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;
use NotificationChannels\Engage\Exceptions\CouldNotSendNotification;
use NotificationChannels\Engage\Exceptions\InvalidConfiguration;

class EngageChannel
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
     * @throws \NotificationChannels\Engage\Exceptions\InvalidConfiguration
     * @throws \NotificationChannels\Engage\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $subscribers = collect($notifiable->routeNotificationFor('Engage'));

        if (! $subscribers->count()) {
            return;
        }

        if (! $token = config('services.vwo-engage.token')) {
            throw InvalidConfiguration::configurationNotSet();
        }

        $message = $notification->toEngage($notifiable);

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
