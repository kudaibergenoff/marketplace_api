<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data): User
    {
        return $this->userRepository->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function login(array $credentials)
    {
        $user = $this->userRepository->findByEmail($credentials['email']);

        if ($user && Hash::check($credentials['password'], $user->password)) {
            return $user->createToken('auth_token')->plainTextToken;
        }

        throw ValidationException::withMessages([
            'email' => ['Неверные учетные данные.'],
        ]);
    }
}
