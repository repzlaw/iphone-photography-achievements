<?php

namespace App\Observers;

use App\Models\Comment;
use App\Events\CommentWritten;

class CommentObserver
{
    /**
     * Handle the Comment "created" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function created(Comment $comment)
    {
        //fire comment written event when a comment is created
        event(new CommentWritten($comment));
    }

    /**
     * Handle the Comment "updated" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function updated(Comment $comment)
    {
        //fire comment written event when a comment is created
        event(new CommentWritten($comment));
    }

}
