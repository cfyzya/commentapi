<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Jobs\LogCurrentCommentCount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SomethingToDoWhenCommentCreated
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommentCreated $event): void
    {
        Log::debug('comment created', ['comment' => $event->comment]);
        LogCurrentCommentCount::dispatch();
    }
}
