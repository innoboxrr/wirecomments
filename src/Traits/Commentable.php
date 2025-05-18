<?php

namespace Innoboxrr\Wirecomments\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Innoboxrr\Wirecomments\Models\Comment;

trait Commentable
{

    /**
     * @return MorphMany
     */
    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

}
