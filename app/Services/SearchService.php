<?php

namespace App\Services;

use App\Repositories\CommentsRepository;

class SearchService
{

    public function __construct(private CommentsRepository $commentsRepository)
    {
    }

    public function searchComments($search)
    {
        return $this->commentsRepository->search($search);
    }

}
