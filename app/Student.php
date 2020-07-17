<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
   protected $table = 'gpts_student';
   
   /**
     * Get the notification.
     *
     * @param  string  $value
     * @return string
     */
    public function getNotificationAttribute($value)
    {
        return json_decode($value);
    }
	
	/**
     * Get the communication.
     *
     * @param  string  $value
     * @return string
     */
	 public function getCommunicationAttribute($value){
		 return json_decode($value);
	 }
	 
	 /**
     * Get the grade in cgpa.
     *
     * @param  string  $value
     * @return string
     */
	  public function getGradeInCgpaAttribute($value){
		 return json_decode($value);
	 }
	 
	 /**
     * Get the grade in percentage.
     *
     * @param  string  $value
     * @return string
     */
	  public function getPerInClassAttribute($value){
		 return json_decode($value);
	 }
	 
	 /**
     * Get the grade in career.
     *
     * @param  string  $value
     * @return string
     */
	 public function getCareerInterestAttribute($value){
		 return json_decode($value);
	 }
	 
	 /**
     * Get the grade in entrance exam.
     *
     * @param  string  $value
     * @return string
     */
	 public function getEntranceExamAttribute($value){
		 return json_decode($value);
	 }
}
