<?php

namespace App\Repositories;


use App\DTOs\UserDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    public function create(UserDTO $dto)
    {
        return User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password,
        ]);
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }

    public function save(int $id, UserDTO $dto)
    {
        // TODO: Implement save() method.
    }

    public function find(int $id)
    {
        // TODO: Implement find() method.
    }
}
