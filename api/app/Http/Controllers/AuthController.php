<?php

namespace App\Http\Controllers;

use App\Application\CreateUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @throws HttpException
     * @return string
     */
    public function login(Request $request): string
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
        } catch (ValidationException $e) {
            throw new HttpException(
                400,
                'Os seguintes campos são obrigatórios: ' . implode(', ', array_keys($e->errors()))
            );
        }
 
        try  {
            if (Auth::attempt($credentials)) {
                $user = User::find(Auth::id());
                $tokenName = 'token-' . $user->id . '-' . time();

                $user->save();

                $token = $user->createToken($tokenName)->plainTextToken;
                
                return response()->json([
                    'token' => $token
                ])->getContent();
            }

            throw new UnauthorizedException('Invalid credentials', 401);
        } catch (UnauthorizedException $e) {
            throw new HttpException($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @throws HttpException
     * @return string
     */
    public function register(Request $request): string
    {
        try {
            $validator = $request->validate([
                'name' => ['required', 'string'],
                'email' => ['required', 'email'],
                'password' => ['required', 'min:6'],
            ]);
        } catch (ValidationException $e) {
            throw new HttpException(
                400,
                'Os seguintes campos são obrigatórios: ' . implode(', ', array_keys($e->errors()))
            );
        }

        $user = new CreateUser($request->all());

        return response()->json($user->create())->getContent();
    }
}
