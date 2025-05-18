<?php

use Illuminate\Database\Eloquent\Model;

class CommentStub extends Model
{
    use \Innoboxrr\Wirecomments\Traits\Commentable;

    protected $connection = 'testbench';

    public $table = 'comments';

}
