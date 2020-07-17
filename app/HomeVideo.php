<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class HomeVideo extends Model
{
    use Sortable;
   protected $table = 'gpts_home_video';
   
}
