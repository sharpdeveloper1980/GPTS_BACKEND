<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Edieo extends Model
{
   protected $table = 'gpts_edieo';
   use Sortable;
}
