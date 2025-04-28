<?php

namespace App\Policies;

use App\Models\Comments;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentsPolicy
{

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comments $comments): Response
    {
        return $comments->isOwnedBy($user) ? Response::allow() : Response::deny('You are not allowed to update comments.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comments $comments): Response
    {
        return $comments->isOwnedBy($user) ? Response::allow() : Response::deny('You are not authorized to delete comments.');
    }

}
