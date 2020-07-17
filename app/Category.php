<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Category extends Model
{
	use Sortable;
	
    protected $table = 'gpts_category';
	
	protected $fillable = ['name', 'description', 'slug', 'status'];
	
	public $sortable = ['name'];
}
