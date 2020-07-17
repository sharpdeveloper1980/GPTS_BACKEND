<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Illuminate\Http\Request;
use App\User;
use GuzzleHttp\Client;
use URL;
use Mail;
use App\Helpers\Helper;

class WebinarController extends Controller
{

	public function response(Request $request){
		dd($request->all());
	}

	public function callZoom(){
		$post['email'] = "lakhan@greatplacetostudy.org";
		$post['first_name'] = "Lakhan";
		$post['last_name'] = "Bisht";

        $url = 'https://api.zoom.us/v2/webinars/705710594/registrants';
        
        $data=json_encode($post);
		$res = Helper::zoomAPI($url,$data);

        return $res;
	}

    public function register(Request $request){
        
        error_reporting(0);

        $registered=$request->input('registered');
        $full_name=$request->input('full_name');
        $email_id=$request->input('email_id');
        $school=$request->input('school');
        $phone=$request->input('phone');
        $class=$request->input('class');
        $type=$request->input('type');
        $webinar_id=$request->input('webinar_id');

        if($registered==1){
        	
        	$validator = Validator::make($request->all(), [
                'email_id' => 'required|email|max:80',
                'webinar_id'=>'required|integer|between:1,15',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->all(), 'code' => '500']);
            } else {
            	$email_chk = \DB::select("SELECT id,name FROM webinar_subscriber WHERE email_id='$email_id'");
				$user_id=$email_chk[0]->id;

				if($user_id){
					$full_name=$email_chk[0]->name;
					
					$webinar = \DB::select("SELECT id FROM webinar_assign WHERE user_id='$user_id' AND webinar_id='$webinar_id'");

					$assign_id=$webinar[0]->id;

					if(!$assign_id){
						\DB::table('webinar_assign')->insert([
							'user_id' => $user_id,
						    'webinar_id'=>$webinar_id
						]);

						$webinar = \DB::select("SELECT id,name,subject,host,cover,schedule,startend,webinar_link FROM webinar_events WHERE id='$webinar_id'");
						$subject=$webinar[0]->subject;

						$data=array('attendee_id'=>$user_id,'attendee_name'=>$full_name,'webinar'=>$webinar[0]->name,'subject'=>$webinar[0]->subject,'host'=>$webinar[0]->host,'cover'=>$webinar[0]->cover,'schedule_date'=>date("l, jS F Y",strtotime($webinar[0]->schedule)),'schedule_time'=>date("h:i A",strtotime($webinar[0]->schedule)),'startend'=>$webinar[0]->startend,'webinar_link'=>$webinar[0]->webinar_link);
						
						Mail::send('webinar_mail', $data, function($message) use ($subject,$full_name,$email_id) {
					         $message->to($email_id, $full_name)->subject('Live Webinar Session for '.$subject.' | Great Place To Study');
					         $message->from('info@greatplacetostudy.com','GPTS');
					    });

						return response()->json(['msg' => 'You have been registered for upcoming webinar.', 'code' => '200']);
					
					}else{
						return response()->json(['msg' => 'You are already registered for this webinar.', 'code' => '200']);
					}
					
				}else{
					return response()->json(['msg' => 'You are not registered with provided email id.', 'code' => '200']);
				}
            }

        }else
        if($registered==0){

        	$validator = Validator::make($request->all(), [
                'full_name' => 'required|max:50',
                'email_id' => 'required|email|max:80',
                'school' => 'required|max:90',
                'phone' => 'required|max:15',
                'class' => 'required|max:10',
                'type' => 'required|integer|between:1,4',
                'webinar_id'=>'required|integer|between:1,15',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->all(), 'code' => '500']);
            } else {
				
				$email_chk = \DB::select("SELECT id,name FROM webinar_subscriber WHERE email_id='$email_id'");
				$user_id=$email_chk[0]->id;
				
				if($user_id){
						
					$full_name=$email_chk[0]->name;
					
					$webinar = \DB::select("SELECT id FROM webinar_assign WHERE user_id='$user_id' AND webinar_id='$webinar_id'");

					$assign_id=$webinar[0]->id;

					if(!$assign_id){
						\DB::table('webinar_assign')->insert([
							'user_id' => $user_id,
						    'webinar_id'=>$webinar_id
						]);

						$webinar = \DB::select("SELECT id,name,subject,host,cover,schedule,startend,webinar_link FROM webinar_events WHERE id='$webinar_id'");
						$subject=$webinar[0]->subject;

						$data=array('attendee_id'=>$user_id,'attendee_name'=>$full_name,'webinar'=>$webinar[0]->name,'subject'=>$webinar[0]->subject,'host'=>$webinar[0]->host,'cover'=>$webinar[0]->cover,'schedule_date'=>date("l, jS F Y",strtotime($webinar[0]->schedule)),'schedule_time'=>date("h:i A",strtotime($webinar[0]->schedule)),'startend'=>$webinar[0]->startend,'webinar_link'=>$webinar[0]->webinar_link);
						
						Mail::send('webinar_mail', $data, function($message) use ($subject,$full_name,$email_id) {
					         $message->to($email_id, $full_name)->subject('Live Webinar Session for '.$subject.' | Great Place To Study');
					         $message->from('info@greatplacetostudy.com','GPTS');
					    });

						return response()->json(['msg' => 'You have been registered for upcoming webinar.', 'code' => '200']);
					
					}else{
						return response()->json(['msg' => 'You are already registered for this webinar.', 'code' => '200']);
					}

				}else{
					
					$user_id=\DB::table('webinar_subscriber')->insertGetId([
							'name' => $full_name,
						    'email_id' => $email_id,
						    'school'=>$school,
						    'phone'=>$phone,
						    'class'=>$class,
						    'type'=>$type,
						    'cdate'=>date('Y-m-d H:i:s')
						 ]);
						
						\DB::table('webinar_assign')->insert([
							'user_id' => $user_id,
						    'webinar_id'=>$webinar_id
						]);
						
						$webinar = \DB::select("SELECT id,name,subject,host,cover,schedule,startend,webinar_link FROM webinar_events WHERE id='$webinar_id'");
						$subject=$webinar[0]->subject;

						$data=array('attendee_id'=>$user_id,'attendee_name'=>$full_name,'webinar'=>$webinar[0]->name,'subject'=>$webinar[0]->subject,'host'=>$webinar[0]->host,'cover'=>$webinar[0]->cover,'schedule_date'=>date("l, jS F Y",strtotime($webinar[0]->schedule)),'schedule_time'=>date("h:i A",strtotime($webinar[0]->schedule)),'startend'=>$webinar[0]->startend,'webinar_link'=>$webinar[0]->webinar_link);

						Mail::send('webinar_mail', $data, function($message) use ($subject,$full_name,$email_id) {
					         $message->to($email_id, $full_name)->subject('Live Webinar Session for '.$subject.' | Great Place To Study');
					         $message->from('info@greatplacetostudy.com','GPTS');
					    });
						
				}

				if($user_id){
					return response()->json(['msg' => 'You have been registered for upcoming webinar.', 'code' => '200']);
				}else{
					return response()->json(['msg' => 'Something went wrong', 'code' => '500']);
				}
            }
        }else{
        	return response()->json(['msg' => 'registered field invalid', 'code' => '500']);
		}
    }
}
