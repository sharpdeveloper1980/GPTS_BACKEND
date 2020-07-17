<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class CollegeCourse extends Model
{
   protected $table = 'gpts_college_course';
    /**
     * Set the created at.
     *
     * @param  string  $value
     * @return void
     */
    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = date('Y-m-d');
    }
    /**
     * Set the deadline.
     *
     * @param  string  $value
     * @return void
     */
    public function setDeadlineAttribute($value)
    {
        $this->attributes['deadline'] = date('Y-m-d', strtotime($value));
    }
   
}
