<?php

namespace App\Application;

use App\Enum\NotificationStatusEnum;
use App\Interface\NotificationInterface;
use App\Models\Notification;
use App\Models\User;
use Exception;

/**
 * Send an internal notification
 */
class InternalNotification implements NotificationInterface
{
    /**
     * @param array $data
     * @throws Exception
     * @return bool
     */
    public function notify(array $data): bool
    {
        try {
            $user = User::where('email', $data['email'])->first();
        } catch (Exception $e) {
            throw new Exception('Usuário não encontrado', 404);
        }

        try {
            $notification = new Notification;
            $notification->id_user = $user->id;
            $notification->message = $data['message'];
            $notification->status = NotificationStatusEnum::NOT_READ->name;
            $notification->save();
        } catch (Exception $e) {
            dd($e);
            throw new Exception('Erro ao salvar a notificação', 500);
        }

        return true;
    }
}
