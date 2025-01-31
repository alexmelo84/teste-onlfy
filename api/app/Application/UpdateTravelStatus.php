<?php

namespace App\Application;

use App\Abstract\AbstractTravel;
use App\Models\Travel;
use Exception;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Update the travel status
 */
class UpdateTravelStatus extends AbstractTravel
{
    /**
     * @param int
     */
    protected int $travelID;

    /**
     * @param string
     */
    protected string $status;

    /**
     * @param string
     */
    protected string $travelMethod;

    /**
     * @param int $travelID
     * @param string $status
     */
    public function __construct(
        int $travelID,
        string $status
    ) {
        $this->travelID = $travelID;
        $this->status = $status;
    }

    /**
     * @return Travel
     */
    public function update(): Travel
    {
        try {
            $travel = $this->getTravel();
            if (empty($travel)) {
                throw new Exception('A viagem não foi encontrada', 404);
            }
        } catch (Exception $e) {
            throw new HttpException($e->getCode(), $e->getMessage());
        }

        try {
            if (!$this->validateSameRequestingUser($travel->id_user, Auth::id())) {
                throw new Exception('Usuário da viagem não pode alterar o status da própria viagem', 404);
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

        $this->travelMethod = $travel->method;

        $travelMethodFactory = $this->getTravelMethodFactory();
        return $travelMethodFactory->updateStatus(
            $this->travelID,
            $this->status
        );
    }
}
