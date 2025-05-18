<?php

use Illuminate\Database\Eloquent\Model;
use Innoboxrr\Wirecomments\Scopes\CommentScopes;

class ArticleStub extends Model
{
    use \Innoboxrr\Wirecomments\Traits\Commentable;

    protected $connection = 'testbench';

    public $table = 'articles';

}
