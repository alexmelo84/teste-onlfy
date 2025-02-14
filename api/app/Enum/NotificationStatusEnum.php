<?php

namespace App\Enum;

enum NotificationStatusEnum: string {
    case NOT_READ = 'Não lido';
    case READ = 'Lido';

    /**
     * @return array
     */
    public static function toArray(): array
    {
        return [
            self::NOT_READ->name,
            self::READ->name
        ];
    }

    /**
     * @return array
     */
    public static function valuesToArray(): array
    {
        return [
            self::NOT_READ->value,
            self::READ->value
        ];
    }
}