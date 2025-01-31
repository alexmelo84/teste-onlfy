<?php

namespace App\Factory;

use App\Enum\TravelStatusEnum;
use App\Interface\TravelFactoryInterface;
use App\Models\Travel;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Date;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

    /**
     * @param int $id
     * @param string $status
     * @return Travel
     */
    public function updateStatus(
        int $id,
        string $status
    ): Travel {
        $travel = Travel::find($id);

        $travel->status = TravelStatusEnum::searchByValue($status);
        $travel->save();

        return $travel;
    }

    public function cancel(int $id): Travel
    {
        $travel = Travel::find($id);

        try {
            if (!$this->validateTravelStarted($travel->start_date)) {
                throw new Exception();
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }

        try {
            if (!$this->validateDate($travel->start_date)) {
                throw new Exception();
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }

        $travel->status = TravelStatusEnum::C->name;
        $travel->save();

        return $travel;
    }

    /**
     * @param string $date
     * @throws Exception
     * @return bool
     */
    private function validateTravelStarted(string $date): bool
    {
        $travelDate = new DateTime($date);
        $today = new DateTime();

        if ($travelDate < $today) {
            throw new Exception('A viagem já iniciou e não pode ser cancelada', 400);
        }

        return true;
    }

    /**
     * @param string $date
     * @throws Exception
     * @return bool
     */
    private function validateDate(string $date): bool
    {
        $travelDate = new DateTime($date);
        $today = new DateTime();
        $dateDiff = $travelDate->diff($today);

        if ($dateDiff->days < 2) {
            throw new Exception('A viagem só pode ser cancelada até 2 dias antes de seu início', 400);
        }

        return true;
    }
}
