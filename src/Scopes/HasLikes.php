<?php

namespace Innoboxrr\Wirecomments\Scopes;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Innoboxrr\Wirecomments\Models\CommentLike;
use Innoboxrr\Wirecomments\Models\User;

trait HasLikes
{
    /**
     * @return HasMany
     */
    public function likes(): HasMany
    {
        return $this->hasMany(CommentLike::class);
    }

    /**
     * @return false|int
     */
    public function isLiked(): bool|int
    {
        $ip = request()->ip();
        $userAgent = request()->userAgent();
        if (auth()->user()) {
            return User::with('likes')->whereHas('likes', function ($q) {
                $q->where('comment_id', $this->id);
            })->count();
        }

        if ($ip && $userAgent) {
            return $this->likes()->forIp($ip)->forUserAgent($userAgent)->count();
        }

        return false;
    }

    /**
     * @return bool
     */
    public function removeLike(): bool
    {
        $ip = request()->ip();
        $userAgent = request()->userAgent();
        if (auth()->user()) {
            return $this->likes()->where('user_id', auth()->user()->id)->where('comment_id', $this->id)->delete();
        }

        if ($ip && $userAgent) {
            return $this->likes()->forIp($ip)->forUserAgent($userAgent)->delete();
        }

        return false;
    }
}
