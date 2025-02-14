<?php

namespace App\Interface;

interface NotificationInterface
{
    public function notify(array $data): bool;
}
