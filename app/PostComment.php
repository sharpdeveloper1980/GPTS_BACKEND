<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class PostComment extends Model
{
    use Sortable;
	
    protected $table = 'gpts_post_comment';
	
	protected $fillable = ['post_id', 'comment', 'status'];
	
	public $sortable = ['post_id'];
      
}
