<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'comment_text',
        'user_id',
        'news_id',
        'rating'
    ];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::saving(function (Comments $comment) {
            $comment->user_id = $comment->user_id ?: auth()->id();
        });
    }

    /**
     *
     *  Check is the user the author
     *
     * @param $user
     * @return bool
     */
    public function isOwnedBy($user): bool
    {
        return $this->user_id == $user->id;
    }
}
