<?php

namespace App\Abstract;

use App\Enum\TravelMethodEnum;
use App\Enum\TravelStatusEnum;
use App\Factory\AirplaneTravelFactory;
use App\Interface\TravelFactoryInterface;
use App\Models\User;
use DateTime;

abstract class AbstractTravel
{
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
}
