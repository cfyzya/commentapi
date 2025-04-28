<?php

namespace App\DTOs;

use Illuminate\Http\Request;

readonly class CommentsDTO
{
    public function __construct(
        public string $commentText,
        public int $userId,
        public int $newsId,
        public int $rating = 0
    )
    {

    }

    public static function fromRequest(Request $request): CommentsDTO{
        return new self(
            commentText: $request->comment_text,
            userId: $request->user()->id,
            newsId: $request->news_id,
            rating: $request->rating ?: 0
        );
    }

}
