<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserType extends Authenticatable
{
	
    protected $table = 'user_type';


}
