<?php

namespace App\Factory;

use App\Enum\TravelStatusEnum;
use App\Interface\TravelFactoryInterface;
use App\Models\Travel;
use DateTime;

class AirplaneTravelFactory implements TravelFactoryInterface
{
    /**
     * @param int $userID
     * @param string $travelMethod
     * @param string $destination
     * @param string $startDate
     * @param string $endDate
     * @param string $status
     * @return Travel
     */
    public function create(
        int $userID,
        string $travelMethod,
        string $destination,
        string $startDate,
        string $endDate,
        string $status
    ): Travel {
        $travel = new Travel();

        $travel->id_user = $userID;
        $travel->method = $travelMethod;
        $travel->destination = $destination;
        $travel->start_date = DateTime::createFromFormat('d/m/Y', $startDate);
        $travel->end_date = DateTime::createFromFormat('d/m/Y', $endDate);
        $travel->status = TravelStatusEnum::searchByValue($status);
        $travel->save();

        return $travel;
    }

    public function updateStatus(
        int $id,
        string $status
    ): Travel {
        $travel = Travel::find($id);

        $travel->status = TravelStatusEnum::searchByValue($status);
        $travel->save();

        return $travel;
    }
}
