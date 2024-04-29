<?php

namespace App\Services;

use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseNotificationsService
{
    private $messaging;

    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }

    public function sendByToken($token, $title, $body, $path, $data)
    {
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(Notification::create($title, $body))
            ->withData([
                'data' => json_encode($data),
                'notification_foreground' => true,
                'redirectPath' => $path, //path
                'content-available' => 1,
                'vibrate' => 1,
                'sound' => 'default',
            ]);
        $this->messaging->send($message);
    }
}
