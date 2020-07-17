<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Sop extends Model
{
   protected $table = 'gpts_sop';

   /**
     * Get the comments for the blog post.
     */
    public function sopAnswer()
    {
        return $this->hasOne('App\SopAnswer','sopid','id');
    }
}
