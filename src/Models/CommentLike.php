<?php

namespace Innoboxrr\Wirecomments\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Innoboxrr\Wirecomments\Database\Factories\CommentFactory;
use Innoboxrr\Wirecomments\Models\Presenters\CommentPresenter;
use Innoboxrr\Wirecomments\Scopes\CommentScopes;

class CommentLike extends Model
{

    /**
     * @var string
     */
    protected $table = 'wire_comment_likes';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'ip',
        'user_agent',
    ];


    /**
     * @param $query
     * @param  string  $ip
     * @return mixed
     */
    public function scopeForIp($query, string $ip): mixed
    {
        return $query->where('ip', $ip);
    }

    /**
     * @param $query
     * @param  string  $userAgent
     * @return mixed
     */
    public function scopeForUserAgent($query, string $userAgent): mixed
    {
        return $query->where('user_agent', $userAgent);
    }

}
