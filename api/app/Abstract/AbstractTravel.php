<?php

namespace App\Abstract;

use App\Enum\TravelMethodEnum;
use App\Enum\TravelStatusEnum;
use App\Factory\AirplaneTravelFactory;
use App\Interface\TravelFactoryInterface;
use App\Models\Travel;
use App\Models\User;
use DateTime;

abstract class AbstractTravel
{
    /**
     * @param int
     */
    protected int $travelID;

    /**
     * @param string
     */
    protected string $travelMethod;

    /**
     * @param int
     */
    protected int $userID;

    /**
     * @param string
     */
    protected string $startDate;

    /**
     * @param string
     */
    protected string $endDate;

    /**
     * @param string
     */
    protected string $status;

    /**
     * @param array
     */
    protected array $params;

    /**
     * @return bool
     */
    protected function validateTravelMethod(): bool
    {
        if (in_array($this->travelMethod, TravelMethodEnum::toArray())) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function validateRequestingUser(): bool
    {
        $user = User::find($this->userID);
        if (empty($user)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function validateStartDate(): bool
    {
        $format = 'd/m/Y';
        $dateObject = DateTime::createFromFormat($format, $this->startDate);
        return $dateObject && $dateObject->format($format) === $this->startDate;
    }

    /**
     * @return bool
     */
    protected function validateEndDate(): bool
    {
        $format = 'd/m/Y';
        $dateObject = DateTime::createFromFormat($format, $this->endDate);
        return $dateObject && $dateObject->format($format) === $this->endDate;
    }

    /**
     * @return bool
     */
    protected function validateTravelStatus(): bool
    {
        if (in_array($this->status, TravelStatusEnum::valuesToArray())) {
            return true;
        }

        return false;
    }

    /**
     * @return TravelFactoryInterface
     */
    protected function getTravelMethodFactory(): TravelFactoryInterface
    {
        switch ($this->travelMethod) {
            case TravelMethodEnum::AIRPLANE->value:
                return new AirplaneTravelFactory;
                break;
        }
    }

    /**
     * @return Travel|null
     */
    protected function getTravel(): ?Travel
    {
        return Travel::find($this->travelID);
    }

    /**
     * @param int $travelUserID
     * @param int $currentUserID
     * @return bool
     */
    protected function validateSameRequestingUser(int $travelUserID, int $currentUserID): bool
    {
        if ($travelUserID === $currentUserID) {
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    protected function setParams(): array
    {
        $params = [];

        if (isset($this->params['status']) && !empty($this->params['status'])) {
            $params['status'] = TravelStatusEnum::searchByValue($this->params['status']);
        }

        if (isset($this->params['destination']) && !empty($this->params['destination'])) {
            $params['destination'] = $this->params['destination'];
        }

        if (isset($this->params['start_date']) && !empty($this->params['start_date'])) {
            $startDate = DateTime::createFromFormat('d/m/Y', $this->params['start_date']);
            $params[] = [
                'start_date',
                '>=',
                $startDate->format('Y-m-d')
            ];
        }

        if (isset($this->params['end_date']) && !empty($this->params['end_date'])) {
            $endDate = DateTime::createFromFormat('d/m/Y', $this->params['end_date']);
            $params[] = [
                'end_date',
                '<=',
                $endDate->format('Y-m-d')
            ];
        }

        return $params;
    }
}
