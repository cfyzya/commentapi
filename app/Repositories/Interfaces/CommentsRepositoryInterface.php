<?php

namespace App\Repositories\Interfaces;

use App\DTOs\CommentsDTO;

interface CommentsRepositoryInterface
{
    public function create(CommentsDTO $dto);

    public function delete(int $id);

    public function save(int $id, CommentsDTO $dto);

    public function find(int $id);

}
