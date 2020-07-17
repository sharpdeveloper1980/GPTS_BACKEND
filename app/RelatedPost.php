<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class RelatedPost extends Model
{
  
	
    protected $table = 'gpts_related_post';
	
	protected $fillable = ['post_id', 'related_post_id'];

      
}
