<?php
namespace App\Services;

use App\Services\FirebaseNotificationsService;
use App\user_notification;
use App\User;

class NotificationsService
{
    private $firebaseMessagingService;

    public function __construct(FirebaseNotificationsService $firebaseMessagingService)
    {
        $this->firebaseMessagingService = $firebaseMessagingService;
    }

    public function sendToUser($userId, $data)
    {
        // Push Notification
        $notification = user_notification::create([
            'title' => $data['title'],
            'body' => $data['body'],
            'path' => $data['path'], //path
            'id_user' => $userId,
        ]);
        $user = User::find($userId);
        if ($user && $user->TokenNotificacion) {
            try {
                $this->firebaseMessagingService->sendByToken($user->TokenNotificacion, $data['title'], $data['body'], $data['path'], []);
            } catch (\Throwable $th) {
                echo("<script>console.log('PHP: ".$user->id."');</script>");
            }
            
        }
    }

}
