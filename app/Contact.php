<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;

class Contact extends Authenticatable
{
		use Sortable;
   		protected $table = 'gpts_contact';
   
}
	