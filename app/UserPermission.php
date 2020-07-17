<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;
use App\UserType;

class UserPermission extends Authenticatable
{
	use Sortable;
    protected $table = 'user_permission';
	
	public function getUserTypeAttribute($value)
    {
			$getResult = UserType::select('type')->whereId($value)->first();
			return $getResult->type;
	}
	public function getEditAttribute($value)
    {
			switch ($value) {
				case 1:
					return 'Yes';
					break;
				case 0:
					return 'No';
					break; 
				default:
					return 'No';
					break;
			}
			
	}
	public function getAddAttribute($value)
    {
			switch ($value) {
				case 1:
					return 'Yes';
					break;
				case 0:
					return 'No';
					break; 
				default:
					return 'No';
					break;
			}
			
	}
	public function getDeleteAttribute($value)
    {
			switch ($value) {
				case 1:
					return 'Yes';
					break;
				case 0:
					return 'No';
					break; 
				default:
					return 'No';
					break;
			}
			
	}
	
	
}
