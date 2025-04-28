<?php

namespace App\Repositories;

use App\DTOs\CommentsDTO;
use App\Models\Comments;
use App\Repositories\Interfaces\CommentsRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class CommentsRepository implements CommentsRepositoryInterface
{

    public function create(CommentsDTO $dto)
    {
        return Comments::create([
            'comment_text' => $dto->commentText,
            'user_id' => $dto->userId,
            'news_id' => $dto->newsId,
            'rating' => $dto->rating,
        ]);
    }

    public function delete(int $id): bool
    {
        return Comments::destroy($id);
    }

    public function save(int $id, CommentsDTO $dto)
    {
        return tap(Comments::findOrFail($id))->update([[
            'comment_text' => $dto->commentText,
            'user_id' => $dto->userId,
            'news_id' => $dto->newsId,
            'rating' => $dto->rating,
        ]]);
    }

    public function find(int $id)
    {
        return Comments::find($id);
    }

    public function getByNewsId(int $newsId)
    {
        return Cache::remember('commentsByNewsId:'. $newsId, 60, function () use ($newsId) {
            return Comments::where('news_id', '=', $newsId)
                ->paginate(20);
        });

    }

    public function search(string $search)
    {
        return Comments::with('user')
            ->whereFullText('comment_text', '%' . $search . '%')
            ->paginate(20, ['id', 'comment_text', 'user_id', 'rating']);
    }
}
