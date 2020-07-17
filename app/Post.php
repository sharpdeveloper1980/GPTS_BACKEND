<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Post extends Model
{
    use Sortable;
	
    protected $table = 'gpts_post';
	
	protected $fillable = ['titile'];
	
	public $sortable = ['title'];
      
}
