<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
   public $timestamps = false;
   
   protected $table = 'gpts_notify';
}
