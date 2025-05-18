<?php

namespace Innoboxrr\Wirecomments\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as BaseUser;
use Innoboxrr\Wirecomments\Database\Factories\UserFactory;
use Innoboxrr\Wirecomments\Traits\HasUserAvatar;

class User extends BaseUser
{
    use HasUserAvatar, HasFactory;

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @return UserFactory
     */
    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommentLike::class);
    }
}
