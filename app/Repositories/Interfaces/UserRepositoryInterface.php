<?php

namespace App\Repositories\Interfaces;

use App\DTOs\UserDTO;

interface UserRepositoryInterface
{
    public function create(userDTO $dto);

    public function delete(int $id);

    public function save(int $id, userDTO $dto);

    public function find(int $id);
}
