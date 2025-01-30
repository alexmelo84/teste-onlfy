<?php

namespace App\Http\Controllers;

use App\Application\CreateTravel;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TravelController extends Controller
{
    /**
     * @param Request $request
     * @throws HttpException
     * @return string
     */
    public function create(Request $request): string
    {
        try {
            $validator = $request->validate([
                'userID' => ['required'],
                'method' => ['required'],
                'destination' => ['required', 'string'],
                'startDate' => ['required'],
                'endDate' => ['required'],
                'status' => ['required', 'string']
            ]);
        } catch (ValidationException $e) {
            throw new HttpException(
                400,
                'Os seguintes campos são obrigatórios: ' . implode(', ', array_keys($e->errors()))
            );
        }

        $travel = new CreateTravel(
            $request->method,
            $request->userID,
            $request->destination,
            $request->startDate,
            $request->endDate,
            $request->status,
        );

        return response()->json($travel->create())->getContent();
    }
}
