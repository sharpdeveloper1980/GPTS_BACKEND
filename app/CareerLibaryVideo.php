<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class CareerLibaryVideo extends Model
{
   protected $table = 'gpts_career_library_video';

   public function faVideo()
   {
       return $this->hasOne('App\MyFav', 'career_video', 'id');
   }
}
