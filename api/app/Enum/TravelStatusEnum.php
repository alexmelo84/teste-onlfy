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

    /**
     * @return array
     */
    public static function valuesToArray(): array
    {
        return [
            self::S->value,
            self::A->value,
            self::C->value
        ];
    }

    /**
     * @param string $value
     * @return string
     */
    public static function searchByValue(string $value): string
    {
        $key = array_search($value, self::valuesToArray());
        return self::toArray()[$key] ?? '';
    }
}