<?php

namespace App\Application;

use App\Abstract\AbstractTravel;
use App\Models\Travel;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Create a travel
 */
class CreateTravel extends AbstractTravel
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
    protected string $destination;

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
     * @param string $travelMethod
     * @param int $userID
     * @param string $destination
     * @param string $startDate
     * @param string $endDate
     * @param string $status
     */
    public function __construct(
        string $travelMethod,
        int $userID,
        string $destination,
        string $startDate,
        string $endDate,
        string $status
    ) {
        $this->travelMethod = $travelMethod;
        $this->userID = $userID;
        $this->destination = $destination;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->status = $status;
    }

    /**
     * @return Travel
     */
    public function create(): Travel
    {
        try {
            if (!$this->validateTravelMethod()) {
                throw new Exception('O tipo de viagem é inválido', 400);
            }
        } catch (Exception $e) {
            throw new HttpException($e->getCode(), $e->getMessage());
        }

        try {
            if (!$this->validateRequestingUser()) {
                throw new Exception('O usuário solicitante não foi encontrado', 404);
            }
        } catch (Exception $e) {
            throw new HttpException($e->getCode(), $e->getMessage());
        }

        try {
            if (!$this->validateStartDate()) {
                throw new Exception('O data de início da viagem é inválida', 404);
            }
        } catch (Exception $e) {
            throw new HttpException($e->getCode(), $e->getMessage());
        }

        try {
            if (!$this->validateEndDate()) {
                throw new Exception('O data de final da viagem é inválida', 404);
            }
        } catch (Exception $e) {
            throw new HttpException($e->getCode(), $e->getMessage());
        }

        try {
            if (!$this->validateTravelStatus()) {
                throw new Exception('O status da viagem é inválido', 400);
            }
        } catch (Exception $e) {
            throw new HttpException($e->getCode(), $e->getMessage());
        }

        $travelMethodFactory = $this->getTravelMethodFactory();
        return $travelMethodFactory->create(
            $this->userID,
            $this->travelMethod,
            $this->destination,
            $this->startDate,
            $this->endDate,
            $this->status
        );
    }
}
