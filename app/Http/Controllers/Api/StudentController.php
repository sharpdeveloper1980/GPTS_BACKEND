<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
Use Redirect;
use Illuminate\Http\Request;
use App\User;
use App\Country;
use App\Student;
use Carbon\Carbon;
use App\Setting;
use App\SopAnswer;
use App\College;
use App\Sop;
use Mail;
use Auth;

class StudentController extends Controller {

    use HasApiTokens,
        Notifiable;

    public function studentSignUpSecondStep(Request $request) {

        $messages = [
            'student_dob.required' => 'Date of birth is required!',
            'student_contact.required' => 'Contact no is required!',
            'student_contact.unique' => 'Contact no has already been registered!',
            'student_dob.required' => 'Date of birth is required!',
            'student_address.required' => 'Addrees is required!',
            'student_pincode.required' => 'Pincode is required!',
            'student_country.required' => 'Country is required!',
            'student_state.required' => 'State is required!'
        ];
        $validator = Validator::make($request->all(), [
                    'student_type'      => 'required',
                    'student_dob'       => 'required',
                    'student_contact'   => 'required|min:10|max:10|unique:users,contact',
                    'student_address'   => 'required',
                    'student_pincode'   => 'required',
                    'student_country'   => 'required',
                    'student_state'     => 'required'
        ], $messages);

        if ($validator->fails() || $request->privacyPolicy!=1 || $request->termsandCondition != 1){
            
            $msg = $validator->errors()->all();
            if($request->termsandCondition != 1){
                array_push($msg, "Select terms and condition!");
            }
            if($request->privacyPolicy!=1){
                array_push($msg, 'Select privacy policy!');
            }

            return response()->json(['msg' => $msg, 'code' => '500']);

        } else {

            $updatecontact = User::whereId($request->user_id)->update(['contact' => $request->student_contact]);
            $userdata = User::whereId($request->user_id)->first();
            $allData = array();
            try {
                $student = new Student;
                $student->user_id = $request->user_id;
                $student->student_type = $request->student_type;
                $student->dob = sprintf("%02d",$request->student_dob_dp['year'])."-".sprintf("%02d",$request->student_dob_dp['month'])."-".sprintf("%02d",$request->student_dob_dp['day']);
                $student->collage_year = $request->student_collage_year;
                $student->prefferred_location = json_encode($request->student_prefferred_location);
                $student->address = $request->student_address;
                $student->pincode = $request->student_pincode;
                $student->country = $request->student_country;
                $student->state = $request->student_state;
                $student->notification = json_encode($request->student_notification);
                $student->communication = json_encode($request->student_communication);
                $student->save();
                $student->setAttribute('student_contact', $userdata->contact);
                $setting = Setting::first();
                $siteEmail = $setting->robot_email;
                if ($userdata->usertype == 1):
                    $user_email = $userdata->email;
                    $user_name = $userdata->name;
                    $data = array('name' => $user_name, 'email' => $user_email, 'title' => 'Welcome to GPTS', 'loginlink' => $request->base_url);
                    Mail::send('emails.secondSignup', $data, function($message) use($user_email, $siteEmail, $user_name) {
                        $message->to($user_email, $user_name)->subject('Welcome to GPTS.');
                        $message->from($siteEmail, 'GPTS Admin');
                    });
                endif;
                return response()->json(['code' => '200', 'data' => $userdata]);
            } catch (Exception $e) {
                return response()->json($e->getErrors());
            }
        }
    }

    /*
      |--------------------------------------------------------------------------
      | Student Information
      |--------------------------------------------------------------------------
      |
      | This method will display the inforation about student
      |
     */

    public function getStudentInfo(Request $request) {


        try {
            $user = User::whereId($request->user_id)->first();
            $username = explode(' ', $user->name);
            $fname = $username[0];
            $mname = (isset($username[2])) ? $username[1] : '';
            if (isset($username[2])) {
                $lname = $username[2];
            } else if (isset($username[1])) {
                $lname = $username[1];
            } else {
                $lname = '';
            }
            // Set new attribute into object

            $user->setAttribute('student_fname', $fname);
            $user->setAttribute('student_mname', $mname);
            $user->setAttribute('student_lname', $lname);
            $student = Student::whereUserId($request->user_id)->first();
            $profileInfoLable = $this->checkPersonalInfoStatus($request->user_id);
            $familyInfoLable = $this->checkFamilyInfoStatus($request->user_id);
            $sop = $this->checkSopStatus($request->user_id);
            $sopVideo = $this->checkSopVideoStatus($request->user_id);
            $educationInfoLable = $this->checkEducationInfoStatus($request->user_id);
            $completeStatus = (($profileInfoLable + $familyInfoLable + $educationInfoLable ) * 100 ) / 3;
            $student->setAttribute('student_profile_info_status', $profileInfoLable);
            $student->setAttribute('student_family_info_status', $familyInfoLable);
            $student->setAttribute('student_education_info_status', $educationInfoLable);
            $student->setAttribute('student_sop_status', $sop);
            $student->setAttribute('student_sop_video_status', $sopVideo);
            $student->setAttribute('student_complete_status', $completeStatus . '%');

            return response()->json(['code' => '200', 'profile_info' => $student, 'user_info' => $user]);
        } catch (Exception $e) {
            return response()->json($e->getErrors());
        }
    }

    /*
      |--------------------------------------------------------------------------
      | Check profile completion
      |--------------------------------------------------------------------------
      |
      | This method will check the profile completion of student
      |
     */

    public function checkPersonalInfoStatus($userid) {

        $student = Student::whereUserId($userid)->first();
        $count = 0;
        $columnArray = array('suffix', 'gender', 'dob', 'address', 'country', 'state', 'pincode', 'permanent_address', 'permanent_country', 'permanent_state', 'permanent_pincode');
        foreach ($columnArray as $key) {

            if (!empty($student->$key)) {
                $count++;
            }
        }
        if ($count >= 11) {
            return 1;
        } else {
            return 0;
        }
    }

    /*
      |--------------------------------------------------------------------------
      | Check family completion
      |--------------------------------------------------------------------------
      |
      | This method will check the profile completion of student's family
      |
     */

    public function checkFamilyInfoStatus($userid) {

        $student = Student::whereUserId($userid)->first();
        $count = 0;
        $columnArray = array('father_name', 'father_occupation', 'mother_name', 'mother_occupation', 'family_income');
        foreach ($columnArray as $key) {

            if (!empty($student->$key)) {
                $count++;
            }
        }
        //return  $count.' '.$countcheck;
        if ($count >= 5) {
            return 1;
        } else {
            return 0;
        }
    }

    /*

     * Sop video status   
     *    
     */

    public function checkSopVideoStatus($userid) {
        $sopvideo = SopAnswer::whereUserId($userid)->whereSopid(2)->count();

        return $sopvideo;
    }

    /*

     * Sop  status   
     *    
     */

    public function checkSopStatus($userid) {
        $soptext = Sop::where('sop_type', 'text')->get();
        $sopid = array();
        foreach ($soptext as $key => $value) :
            $sopid[] = $value->id;
        endforeach;

        $sopvideo = SopAnswer::whereIn('sopid', $sopid)->whereUserId($userid)->count();

        if (count($sopid) == $sopvideo):
            return 1;
        else:
            return 0;
        endif;
    }

    /*
      |--------------------------------------------------------------------------
      | Check education completion
      |--------------------------------------------------------------------------
      |
      | This method will check the profile completion of student's education
      |
     */

    public function checkEducationInfoStatus($userid) {

        $student = Student::whereUserId($userid)->first();
        $count = 0;
        $columnArray = array('current_school', 'type_of_school', 'grade', 'board', 'schooling_with_same_day', 'grade_in_cgpa');
        foreach ($columnArray as $key) {

            if (!empty($student->$key)) {
                $count++;
            }
        }
        if ($count >= 6) {
            return 1;
        } else {
            return 0;
        }
    }

    /*
      |--------------------------------------------------------------------------
      | Student personal information
      |--------------------------------------------------------------------------
      |
      | This method will check the profile completion of student's personal info
      |
     */

    public function editStudentPerInfo(Request $request) {
        // Validation start
        $messages = [
            'student_suffix.required'               => 'Suffix is required.',
            'student_lname.required'            => 'Last name is required.',
            'student_gender.required'               => 'Gender is required.',
            //'student_age.required'                  => 'Age is required.',
            'student_current_address.required'      => 'Current address is required.',
            'student_current_country.required'      => 'Current country is required.',
            'student_current_state.required'        => 'Current state is required',
            'student_permanent_address.required'    => 'Permanent address is required.',
            'student_permanent_country.required'    => 'Permanent country is required.',
            'student_permanent_state.required'      => 'Permanent state is required.',
            'student_permanent_pincode.required'    => 'Permanent pincode is required.',

        ];

        $validator = Validator::make($request->all(), [
                    'student_suffix'                => 'required',
                    'student_lname'             => 'required',
                    'student_gender'                => 'required',
                    //'student_age'                   => 'required',
                    'student_current_address'       => 'required',
                    'student_current_country'       => 'required',
                    'student_current_state'         => 'required',
                    'student_permanent_address'     => 'required',
                    'student_permanent_country'     => 'required',
                    'student_permanent_state'       => 'required',
                    'student_permanent_pincode'     => 'required',
                        ], $messages);

        // EOF validation

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all(), 'code' => '500']);
        } else {

            try {
                $username = $request->student_fname . " " . $request->student_mname . " " . $request->student_lname;
                $user = User::whereId($request->user_id)->update(["name" => $username, "contact" => $request->student_contact]);
                $userInfo = User::whereId($request->user_id)->first();
                $student = Student::whereUserId($request->user_id)->first();
                $student->suffix = $request->student_suffix;
                $student->religious = $request->student_religious;
                $student->gender = $request->student_gender;
                $student->dob = $request->student_dob;
                $student->skype_id = $request->student_skype_id;
                $student->address = $request->student_current_address;
                $student->country = $request->student_current_country;
                $student->state = $request->student_current_state;
                $student->pincode = $request->student_current_pincode;
                // Permanent Address
                $student->permanent_address = $request->student_permanent_address;
                $student->permanent_country = $request->student_permanent_country;
                $student->permanent_city = $request->student_permanent_city;
                $student->permanent_state = $request->student_permanent_state;
                $student->permanent_pincode = $request->student_permanent_pincode;
                //$student->age = $request->student_age;
                $student->home_contact = $request->student_home_contact;
                $student->student_phone_code = $request->student_phone_code;
                $student->ethinicity = $request->student_ethinicity;
                $student->same_as_addr = $request->same_as_addr;
                $student->save();
                
                $uname = explode(' ', $userInfo->name);
                $fname = $uname[0];
                $mname = (isset($uname[2])) ? $uname[1] : '';
                if (isset($uname[2])) {
                    $lname = $uname[2];
                } else if (isset($uname[1])) {
                    $lname = $uname[1];
                } else {
                    $lname = '';
                }
                // Set new attribute into object
                $userInfo->setAttribute('student_fname', $fname);
                $userInfo->setAttribute('student_mname', $mname);
                $userInfo->setAttribute('student_lname', $lname);
                return response()->json(['code' => '200', 'profile_info' => $student, 'user_info' => $userInfo]);
            } catch (Exception $e) {
                return response()->json($e->getErrors());
            }
        }
    }

    /*
      |--------------------------------------------------------------------------
      | Stuednt's family information
      |--------------------------------------------------------------------------
      |
      | This method will check the profile completion of student's family
      |
     */

    public function editStudentFamInfo(Request $request) {
        // Validation start
        $messages = [
            'father_name.required' => 'Father name is required.',
            'father_occupation.required' => 'Father occupation is required.',
            'father_highest_education.required' => 'Father highest education is required.',
            'mother_name.required' => 'Mother name is required.',
            'mother_occupation.required' => 'Mother occupation is required.',
            'mother_highest_education.required' => 'Mother highest education is required.',
            'father_email_id.email' => 'Parent email id is not valid.',
            'father_contact_no.min' => 'Parent contact no must be at least 10 characters.',
            'father_contact_no.max' => 'Parent contact no may not be greater than 10 characters.',
            'mother_email_id.email' => 'Mother email id is not valid.',
            'mother_contact_no.min' => 'Mother contact no must be at least 10 characters.',
            'mother_contact_no.max' => 'Mother contact no may not be greater than 10 characters.',
            'any_sibling.required' => 'Select Sibling.',
        ];

        $validator = Validator::make($request->all(), [
                    'father_name'               => 'required',
                    'father_occupation'         => 'required',
                    'father_highest_education'  => 'required',
                    'mother_name'               => 'required',
                    'mother_occupation'         => 'required',
                    'mother_highest_education'  => 'required',
                    'father_email_id'			=> 'required|email',
                    'father_contact_no'         => 'required',
                    'any_sibling'               => 'required'
                        ], $messages);

        // EOF validation

        if ($validator->fails()) {
            // $errorAll = array();
            // foreach ($validator->errors()->getMessages() as $key => $error) {
            //     $errorDb = array();
            //     $errorDb[$key] = $error[0];
            //     $errorAll[] = $errorDb;
            // }

            return response()->json(['message' => $validator->errors()->all(), 'code' => '500']);
        } else {

            try {
                $userInfo = User::whereId($request->user_id)->first();
                $student = Student::whereUserId($request->user_id)->first();
                $student->father_name = $request->father_name;
                $student->father_occupation = $request->father_occupation;
                $student->father_highest_education = $request->father_highest_education;
                $student->mother_name = $request->mother_name;
                $student->mother_occupation = $request->mother_occupation;
                $student->mother_highest_education = $request->mother_highest_education;
                $student->family_income = $request->family_income;
                $student->father_email_id = $request->father_email_id;
                $student->father_contact_no = $request->father_contact_no;
                $student->mother_email_id = $request->mother_email_id;
                $student->mother_contact_no = $request->mother_contact_no;
                $student->any_sibling = $request->any_sibling;
                $student->save();
                $uname = explode(' ', $userInfo->name);
                $fname = $uname[0];
                $mname = (isset($uname[2])) ? $uname[1] : '';
                if (isset($uname[2])) {
                    $lname = $uname[2];
                } else if (isset($uname[1])) {
                    $lname = $uname[1];
                } else {
                    $lname = '';
                }
                // Set new attribute into object
                $userInfo->setAttribute('student_fname', $fname);
                $userInfo->setAttribute('student_mname', $mname);
                $userInfo->setAttribute('student_lname', $lname);

                return response()->json(['code' => '200', 'profile_info' => $student, 'user_info' => $userInfo]);
            } catch (Exception $e) {
                return response()->json($e->getErrors());
            }
        }
    }

    /*
      |--------------------------------------------------------------------------
      | Student education info
      |--------------------------------------------------------------------------
      |
     */

    public function editStudentEducationInfo(Request $request) {
        $messages = [
            'current_school.required' => 'Current school is required.',
            'type_of_school.required' => 'Type of school is required.',
            'board.required'          => 'Board is required.',
            'grade.required'          => 'Grade is required.',
            'schooling_with_same_day.required' => 'Select schooling through same school option.'
        ];

        $validator = Validator::make($request->all(), [
                    'current_school'            => 'required',
                    'type_of_school'            => 'required',
                    'board'                     => 'required',
                    'grade'                     => 'required',
                    'schooling_with_same_day'   => 'required'
        ], $messages);

        // EOF validation

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all(), 'code' => '500']);
        } else {
            try {
                $userInfo = User::whereId($request->user_id)->first();
                $student = Student::whereUserId($request->user_id)->first();
                $student->current_school = $request->current_school;
                $student->type_of_school = $request->type_of_school;
                $student->grade = $request->grade;
                $student->board = $request->board;
                $student->year_of_graduation = $request->year_of_graduation;
                $student->schooling_with_same_day = $request->schooling_with_same_day;
                $student->previous_school = $request->previous_school;
                $student->reason_for_shifting_school = $request->reason_for_shifting_school;
                $student->grade_in_transfer = $request->grade_in_transfer;
                $student->grade_in_cgpa = json_encode($request->grade_in_cgpa);
                $student->per_in_class = json_encode($request->per_in_class);
                $student->no_of_honors = $request->no_of_honors;
                $student->honors_group = json_encode($request->honors_group);
                $student->year_of_completion = json_encode($request->year_of_completion);
                $student->save();
                $uname = explode(' ', $userInfo->name);
                $fname = $uname[0];
                $mname = (isset($uname[2])) ? $uname[1] : '';
                if (isset($uname[2])) {
                    $lname = $uname[2];
                } else if (isset($uname[1])) {
                    $lname = $uname[1];
                } else {
                    $lname = '';
                }
                // Set new attribute into object
                $userInfo->setAttribute('student_fname', $fname);
                $userInfo->setAttribute('student_mname', $mname);
                $userInfo->setAttribute('student_lname', $lname);

                return response()->json(['code' => '200', 'profile_info' => $student, 'user_info' => $userInfo]);
            } catch (Exception $e) {
                return response()->json($e->getErrors());
            }
        }
    }

    /*
      |--------------------------------------------------------------------------
      | Answer for Sop
      |--------------------------------------------------------------------------
      |
      | This method will handles the all SOP answers which will be receive by student
      |
     */

    public function sopTextAnswer(Request $request) {

        try {

            if($request->id != '' && $request->created_at != ''){
                $sopAnswer = SopAnswer::findOrFail($request->id);
                //$sopAnswer->created_at = $request->created_at;
            }else{
                $sopAnswer = new SopAnswer();
                $sopAnswer->created_at = date('Y-m-d h:i:s');
            }

            $sopAnswer->user_id = $request->user_id;
            $sopAnswer->sopid = $request->sop_id;
            $sopAnswer->answer = $request->answer;
            $sopAnswer->save();

            return response()->json(['code' => '200']);
        } catch (Exception $e) {

            return response()->json($e->getErrors());
        }
    }

    /*
      |--------------------------------------------------------------------------
      | Get Answer for Video Sop
      |--------------------------------------------------------------------------
      |
      | This method will handles the all Video answers which will be receive by student
      |
     */

    public function sopVideoAnswer(Request $request) {

        //echo '<pre>';print_r($request->all());die();

        $orignalName = $request->fileName;
        $tempName = $_FILES['video']['tmp_name'];
        $userid = $request->user_id;
        //print_r($request->all());
        //die();
        try {

            if (empty($orignalName) || empty($tempName)) {
                if (empty($orignalName)) {
                    return response()->json(['code' => '500', 'msg' => 'Invalid temp_name' . $tempName]);
                }
                return response()->json(['code' => '500', 'msg' => 'Invalid file name' . $orignalName]);
            }

            $filename = $orignalName;
            $filePath = 'public/sop/' . $filename;

            if (!move_uploaded_file($tempName, $filePath)) {

                return response()->json(['code' => '500', 'msg' => 'Not uploaded because of server error']);
            } else {
                // save video sop
                $sopAnswer = new SopAnswer();
                $sopAnswer->user_id = $request->user_id;
                $sopAnswer->sopid = $request->sop_id;
                $sopAnswer->filename = $filename;
                $sopAnswer->created_at = date('Y-m-d h:i:s');
                $sopAnswer->save();
                return response()->json(['code' => '200', 'msg' => 'Saved file']);
            }
        } catch (Exception $e) {

            return response()->json($e->getErrors());
        }
    }

    /*
      |--------------------------------------------------------------------------
      | Get text sop student wise
      |--------------------------------------------------------------------------
      |
      | This method will handles the all text SOP answers which will be receive by student
      |
     */

    public function getStudentTextSop(Request $request) {

        // Get School id according to apply by student and then after that sop will be display according school with defualt sop
        $data = []; 
        $user_id = $request->user_id;

        // One to One Relation Mapping
        $sop = Sop::with('sopAnswer')
                ->whereHas('sopAnswer', function($query) use ($user_id) {
                    $query->whereUserId($user_id);
                })
                //->whereSopType('text')
                ->get();
        $allData = array();
        foreach ($sop as $sops) {
            $sopAnswerData = $sops->sopAnswer->toArray();
            $data['sop_id'] = $sops->id;
            $data['name'] = $sops->question;
            $data['answer'] = $sopAnswerData['answer'];
            $allData[] = $data;
        }

        return response()->json(['code' => 200, 'data' => $data]);
    }

    public function getStudentSop(Request $request) {

        // Get School id according to apply by student and then after that sop will be display according school with defualt sop
        $data = []; 
        $difference = '';
        $user_id = $request->user_id;

        $datas = SopAnswer::where('user_id',$user_id)->first();
        // One to One Relation Mapping
        // $sop = Sop::with('sopAnswer')
        //         ->whereHas('sopAnswer', function($query) use ($user_id) {
        //             $query->whereUserId($user_id);
        //         })
        //         ->get();
        // $allData = array();
        // foreach ($sop as $sops) {
        //     $sopAnswerData = $sops->sopAnswer->toArray();
        //     $data['sop_id'] = $sops->id;
        //     $data['name'] = $sops->question;
        //     $data['answer'] = $sopAnswerData['answer'];
        //     $allData[] = $data;
        // }
        if($datas){
            $created = new Carbon($datas->created_at);
            $now = Carbon::now();
            $difference = $created->diffInDays($now);
            $data = $datas->toArray();
            $data['difference'] = $difference;            
        }
        return response()->json(['code' => 200, 'data' => $data]);
    }

    /*
      |--------------------------------------------------------------------------
      | Get text sop student wise
      |--------------------------------------------------------------------------
      |
      |
     */

    public function setObjetive(Request $request) {

        try {

            $query = Student::whereUserId($request->user_id)->update(['objective' => $request->objective]);

            if ($query) {
                return response()->json(['code' => '200']);
            } else {
                return response()->json(['code' => '500', 'msg' => 'Invalid user id']);
            }
        } catch (Exception $e) {

            return response()->json($e->getErrors());
        }
    }

    /*
      |--------------------------------------------------------------------------
      | Get Student Objective
      |--------------------------------------------------------------------------
      |
      | This method will display student's objective
      |
     */

    public function getObjective(Request $request) {
        $query = Student::select('objective', 'user_id')->whereUserId($request->user_id)->first();
        return response()->json(['code' => '200', 'data' => $query]);
    }

    /*
      |--------------------------------------------------------------------------
      | Get student's activity
      |--------------------------------------------------------------------------
      |
      | This method will save the student's activity
      |
     */

    public function setActivity(Request $request) {
        try {

            $query = Student::whereUserId($request->user_id)->update(['activity' => json_encode($request->activity), 'activity_count' => $request->activity_count, 'accept_activity' => $request->accept_activity]);

            if ($query) {
                return response()->json(['code' => '200', 'msg' => 'Activity saved successfully.', 'status' => 1]);
            } else {
                return response()->json(['code' => '500', 'msg' => 'Invalid user id']);
            }
        } catch (Exception $e) {

            return response()->json($e->getErrors());
        }
    }

    /*
      |--------------------------------------------------------------------------
      | Get Student's Activity
      |--------------------------------------------------------------------------
      |
      | This method will display student's activity
      |
     */

    public function getActivity(Request $request) {
        $query = Student::select('activity', 'user_id', 'activity_count', 'accept_activity')->whereUserId($request->user_id)->first();
        return response()->json(['code' => '200', 'data' => $query]);
    }

    /*
      |--------------------------------------------------------------------------
      | Get All Students
      |--------------------------------------------------------------------------
      |
      | This method will display student's list
      |
     */

    public function getStudentList() {
        $userInfo = User::Join('gpts_student as stud', 'stud.user_id', '=', 'users.id')->whereUsertype(1)->get();
        return response()->json(['code' => '200', 'data' => $userInfo]);
    }

}
