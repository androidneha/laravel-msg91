<?php

namespace Laravel\Msg91\Channels;

use Illuminate\Notifications\Notification;
use Laravel\Msg91\Message\Msg91Message;
use Laravel\Msg91\Client;

/**
 * Class Msg91Channel
 * @package Laravel\Msg91\Channels
 */
class Msg91Channel
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Msg91Channel constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $number = $notifiable->routeNotificationFor('msg91', $notification);
        if (empty($number)) {
            return;
        }
        /** @var Msg91Message $message */
        $message = $notification->toMsg91($notifiable);
        $this->client->sms($number, $message->message, $message->sender, $message->route, $message->country);
    }
}
