<?php

namespace App\Services;

use App\DTOs\CommentsDTO;
use App\Events\CommentCreated;
use App\Models\Comments;
use App\Repositories\Interfaces\CommentsRepositoryInterface;

class CommentService
{

    public function __construct(private CommentsRepositoryInterface $commentsRepository)
    {
    }

    public function create(CommentsDto $dto): Comments
    {
        $comment = $this->commentsRepository->create($dto);
        CommentCreated::dispatch($comment);
        return $comment;
    }

    public function update($id, CommentsDto $dto)
    {
        return $this->commentsRepository->save($id, $dto);
    }

    public function delete(int $id)
    {
        return $this->commentsRepository->delete($id);
    }

    public function getById(int $id)
    {
        return $this->commentsRepository->find($id);
    }

    public function getByNewsId(int $id)
    {
        return $this->commentsRepository->getByNewsId($id);
    }

}
