<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class FeaturedVideo extends Model
{
    use Sortable;
   protected $table = 'gpts_featured_video';
}
