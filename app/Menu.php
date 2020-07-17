<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;

class Menu extends Authenticatable
{
	use Sortable;
	
    protected $table = 'menu';
		
	public $sortable = ['menu'];
}
