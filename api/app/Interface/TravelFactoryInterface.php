<?php

namespace App\Interface;

use App\Models\Travel;

interface TravelFactoryInterface
{
    public function create(
        int $userID,
        string $travelMethod,
        string $destination,
        string $startDate,
        string $endDate,
        string $status
    ): Travel;

    public function updateStatus(
        int $id,
        string $status
    ): Travel;

    public function cancel(int $id): Travel;
}
