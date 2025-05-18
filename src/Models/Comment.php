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
use Innoboxrr\Wirecomments\Scopes\HasLikes;

class Comment extends Model
{

    use CommentScopes, SoftDeletes, HasFactory, HasLikes;

    /**
     * @var string
     */
    protected $table = 'wire_comments';

    /**
     * @var string[]
     */
    protected $fillable = ['body'];

    protected $withCount = [
        'likes',
    ];

    /**
     * @return CommentPresenter
     */
    public function presenter(): CommentPresenter
    {
        return new CommentPresenter($this);
    }

    /**
     * @return bool
     */
    public function isParent(): bool
    {
        return is_null($this->parent_id);
    }

    /**
     * @return BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->oldest();
    }

    /**
     * @return MorphTo
     */
    public function commentable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return CommentFactory
     */
    protected static function newFactory(): CommentFactory
    {
        return CommentFactory::new();
    }
}
