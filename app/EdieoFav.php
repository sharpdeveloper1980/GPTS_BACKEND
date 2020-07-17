<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class EdieoFav extends Model
{
   protected $table = 'gpts_edieo_fav';
   use Sortable;
}
