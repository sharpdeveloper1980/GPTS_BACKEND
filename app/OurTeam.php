<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;

class OurTeam extends Authenticatable
{
		use Sortable;
   		protected $table = 'gpts_ourteam';
   
}
	