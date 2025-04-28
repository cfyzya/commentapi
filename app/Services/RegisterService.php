<?php

namespace App\Services;

use App\DTOs\UserDTO;
use App\Repositories\UserRepository;

class RegisterService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function register(userDTO $dto)
    {
        $user = $this->userRepository->create($dto);
        return $user->createToken($user->email)->plainTextToken;
    }
}
