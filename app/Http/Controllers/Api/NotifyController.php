<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Notify;
use Mail;
Use Redirect;

class NotifyController extends Controller {
    
    public function rcregister(Request $request) {

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|max:50',
            'email' => 'required|email',
            'contact_no' => 'required|max:20',
            'dob' => 'required|date|date_format:Y-m-d',
            'school' => 'required|max:100',
            'standard' => 'required|max:50'
        ]);
        
        if($validator->fails()){
            $errorAll = array();
            foreach ($validator->errors()->getMessages() as $key => $error) {
                array_push($errorAll, $error[0]);
            }

            return response()->json(['message' => $errorAll, 'status_code' => 400], 200);
        }else{
            /* Send to mail */
            $data=array('full_name'=>$request->full_name,'email'=>$request->email,'contact_no'=>$request->contact_no,'dob'=>$request->dob,'school'=>$request->school,'standard'=>$request->standard);

            Mail::send('emails.rc_notify', $data, function($message) {
                 $message->to("info@greatplacetostudy.com", "GPTS")->subject('GPTS - Roychand Scholarship Applicant');
                 $message->from('no-reply@greatplacetostudy.com','Great Place To Study');
            });
            
            return response()->json(['message' => 'Than you for registering with us. We will contact you soon.', 'status_code' => 200]);
        }
    }
    
    public function notify(Request $request) {

        $validator = Validator::make($request->all(), [
            'notify_for' => 'required|in:art_ent,robotics,faaart',
            'name' => 'required|max:50',
            'email' => 'required|email',
            'contact_no' => 'required|max:15',
            'school_name' => 'max:85',
            'location' => 'max:85'
        ]);

        if($validator->fails()){
            $errorAll = array();
            foreach ($validator->errors()->getMessages() as $key => $error) {
                array_push($errorAll, $error[0]);
            }

            return response()->json(['message' => $errorAll, 'status_code' => 400], 200);
        }else{
            
            $chk_count = Notify::where('notify_for',$request->notify_for)->where('email',$request->email)->count();
            
            if($chk_count==0){
                
                $notify = new Notify;
                $notify->notify_for = $request->notify_for;
                $notify->name = $request->name;
                $notify->email = $request->email;
                $notify->contact_no = $request->contact_no;
                $notify->school_name = $request->school_name;
                $notify->location = $request->location;

                $notify->save();
                
                $notify_id = $notify->id;
                
                if($notify_id>0){
                    return response()->json(['message' => 'We will notify you soon.', 'status_code' => 200]);
                }
            }else{
                return response()->json(['message' => 'We will notify you soon.', 'status_code' => 200]);
            }
        }
    }

}