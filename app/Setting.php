<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Kyslik\ColumnSortable\Sortable;

class Setting extends Authenticatable
{
	//use Sortable;
	
    protected $table = 'gpts_setting';
	
	protected $fillable = ['site_name', 'site_url', 'logo_log', 'admin_email','robot_email	', 'created_at'];
	
}
 