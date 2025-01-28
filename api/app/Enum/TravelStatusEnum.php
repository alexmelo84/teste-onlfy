<?php

namespace App\Enum;

enum TravelStatusEnum: string {
    case S = 'Solicitado';
    case A = 'Aprovado';
    case C = 'Cancelado';

    /**
     * @return array
     */
    public static function toArray(): array
    {
        return [
            self::S->name,
            self::A->name,
            self::C->name
        ];
    }
}