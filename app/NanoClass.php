<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class NanoClass extends Model
{
   protected $table = 'gpts_nano_class';
   use Sortable;
}
