<?php

namespace App\Application;

use App\Abstract\AbstractTravel;
use App\Models\Travel;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Return a trael by ID
 */
class GetTravelByID extends AbstractTravel
{
    /**
     * @param int
     */
    protected int $travelID;

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
    public function get(): Travel
    {
        try {
            $travel = $this->getTravel();
            if (empty($travel)) {
                throw new Exception('A viagem não foi encontrada', 404);
            }
        } catch (Exception $e) {
            throw new HttpException($e->getCode(), $e->getMessage());
        }

        return $travel;
    }
}
