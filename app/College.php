<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
   protected $table = 'gpts_college';
   
   /**
     * one to one relationship for college type
     */
    public function collegeType()
    {
        return $this->hasOne('App\CollegeType','id','collage_type');
    }

    /**
     * one to many relationship for college why choose
     */
    public function collegeWhyChoose()
    {
        return $this->hasMany('App\CollegeWhyChoose','college_id','user_id');
    }
   
   /**
     * one to many relationship for college prominent
     */
    public function collegeProminent()
    {
        return $this->hasMany('App\CollegeProminent','college_id','user_id');
    }

    /**
     * one to many relationship for college alumini
     */
    public function collegeAlumini()
    {
        return $this->hasMany('App\CollegeAlumni','college_id','user_id');
    }
    
    /**
     * one to many relationship for college facilities
     */
    public function collegeFacilities()
    {
        return $this->hasMany('App\CollegeFacilities','college_id','user_id');
    }
    
}
