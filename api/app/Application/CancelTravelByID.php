<?php

namespace App\Application;

use App\Abstract\AbstractTravel;
use App\Models\Travel;
use Exception;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Cancel travel by ID
 */
class CancelTravelByID extends AbstractTravel
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
     */
    public function __construct(int $travelID)
    {
        $this->travelID = $travelID;
    }

    /**
     * @return Travel
     */
    public function cancel(): Travel
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

        $this->travelMethod = $travel->method;

        $travelMethodFactory = $this->getTravelMethodFactory();

        try {
            return $travelMethodFactory->cancel($this->travelID);
        } catch (Exception $e) {
            throw new HttpException($e->getCode(), $e->getMessage());
        }
    }
}
