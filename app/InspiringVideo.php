<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class InspiringVideo extends Model
{
    use Sortable;
   protected $table = 'gpts_inspiring_videos';
   
}
