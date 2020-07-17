<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;

class Career extends Authenticatable
{
		use Sortable;
   		protected $table = 'gpts_career_library';

	   public function getCareerOptionsAttribute($value){

	   		return json_decode($value);
	   }
	   public function getTopRecruitersAttribute($value){

	   		return json_decode($value);
	   }
	   public function getExpectedRemunerationAttribute($value){

	   		return json_decode($value);
	   }
	   public function getTraitsInPointersAttribute($value){

	   		return json_decode($value);
	   }
	   public function getFamousePersonaliitiesAttribute($value){

	   		return json_decode($value);
	   }
	   public function getAreaCoverAttribute($value){

	   		return json_decode($value);
	   }
	   public function getTopCollegesAttribute($value){

	   		return json_decode($value);
	   }
           public function getCareerLadderAttribute($value){

	   		return json_decode($value);
	   }
            public function getDoYouKnowAttribute($value){

	   		return json_decode($value);
	   }
           public function getCompetenciesAttribute($value){

	   		return json_decode($value);
	   }
           public function getRelatedCareerAttribute($value){

	   		return json_decode($value);
	   }
            public function getCareerJobsAttribute($value){

	   		return json_decode($value);
	   }
           
            /**
     * Get all related video.
     */
    public function careerVideo()
    {
        return $this->hasMany('App\CareerLibaryVideo','career_id','id');
    }
   
}
	