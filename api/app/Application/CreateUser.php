<?php

namespace App\Application;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Create an account
 */
class CreateUser
{
    /**
     * @var array $input
     */
    private array $input;

    /**
     * @var array $input
     */
    public function __construct(array $input)
    {
        $this->input = $input;
    }

    /**
     * @return User
     */
    public function create(): User
    {
        try {
            $this->validate();
        } catch (Exception $e) {
            throw new HttpException(400, $e->getMessage());
        }

        try {
            $user = new User;
            $user->name = $this->input['name'];
            $user->email = $this->input['email'];
            $user->password = Hash::make($this->input['password']);

            $user->save();
        } catch (Exception $e) {
            throw new HttpException(500, 'Erro ao criar usuário: ' . $e->getMessage());
        }

        return $user;
    }

    /**
     * @param array $input
     * @throws \Exception
     * @return void
     */
    protected function validate(): void
    {
        $user = User::where('email', $this->input['email'])->first();
        if (!empty($user)) {
            throw new Exception('Email já existente');
        }
    }
}
