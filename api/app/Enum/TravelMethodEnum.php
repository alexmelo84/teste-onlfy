<?php

namespace App\Enum;

enum TravelMethodEnum: string {
    case AIRPLANE = 'airplane';
    case BUS = 'bus';
    case CAR = 'car';

    /**
     * @return array
     */
    public static function toArray(): array
    {
        return [
            self::AIRPLANE->value,
            self::BUS->value,
            self::CAR->value
        ];
    }
}
