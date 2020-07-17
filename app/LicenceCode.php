<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;

class LicenceCode extends Authenticatable
{
	use Sortable;
    protected $table = 'gpts_licence_code';
	
}
 