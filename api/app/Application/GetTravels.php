<?php

namespace App\Application;

use App\Abstract\AbstractTravel;
use Illuminate\Support\Facades\DB;

/**
 * Return travels
 */
class GetTravels extends AbstractTravel
{
    /**
     * @param array
     */
    protected array $params;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        $params = $this->setParams();
        $travels = DB::table('travels')->where($params)->get();

        return $travels->toArray();
    }
}
