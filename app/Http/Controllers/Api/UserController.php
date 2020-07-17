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
use App\College;
use App\Setting;
use App\LicenceCode;
use Auth;
use Mail;

class UserController extends Controller {

    use HasApiTokens, Notifiable;
    /*
      |--------------------------------------------------------------------------
      | User Registration
      |--------------------------------------------------------------------------
      |
      | This method handles the registration of new users as well as their | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
    */

    public function signup(Request $request) {

     
        $userdata = User::whereEmail($request->email)->first();
        if (isset($userdata->id) && $userdata->created_by > 0 && empty($userdata->password)) {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
                'usertype' => 'required'
            ]);

        } else if($request->usertype == 1){

            $validator = Validator::make($request->all(), [
                'name'              => 'required',
                'lastname'           => 'required',
                'email'             => 'required|email|unique:users',
                'password'          => 'required',
                'confirm_password'  => 'required|same:password',
                'usertype'          => 'required',
                'school'            => 'required',
                'licence_code'      => 'required'
            ]);

        }else{

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
                'usertype' => 'required'
            ]);

        }

        if ($validator->fails()) {

            $errorAll = array();
            foreach ($validator->errors()->getMessages() as $key => $error) {
                // $errorDb = array();
                // $errorDb[$key] = $error[0];
                // $errorAll[] = $errorDb;
                array_push($errorAll, $error[0]);
            }

            return response()->json(['message' => $errorAll, 'status_code' => 401], 401);

        } else {

            if (isset($userdata->id) && $userdata->created_by > 0 && empty($userdata->password)) {

                $user = User::whereId($userdata->id)->update(['password' => Hash::make($request->password)]);
                $user_id = $userdata->id;
                $user_contact = $userdata->contact;
            } else {

                if( $request->usertype == 1){

                    $checkLicenceCode = LicenceCode::whereLicenceCode($request->licence_code)
                                        ->whereSchoolAssign($request->school)
                                        ->where('student_assign', '=', 0)
                                        ->count();
                    if($checkLicenceCode == 0){
                        return response()->json(['message' => ['Invalid Licence Code'], 'status_code' => 401], 401);
                        die();
                    }
        
                }

                $user = new User;
                $user->name = $request->name;
                $user->lastname = $request->lastname;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->usertype = $request->usertype;
                $user->save();
                $user_id = $user->id;
                $user_contact = $user->contact;
            }


            $user_email = $request->email;
            $user_name=$request->name." ".$request->lastname;
            $user_usertype = $request->usertype;
            //student email
            $setting = Setting::first();
            $siteEmail = $setting->robot_email;

            if($user->usertype==1):

                LicenceCode::whereLicenceCode($request->licence_code)
                            ->whereSchoolAssign($request->school)
                            ->update(['student_assign' => $user_id, 'student_assign_date' => date('Y-m-d')]);
                
                $user_name=$request->name." ".$request->lastname;
                $data = array('name' => $user_name,'email'=>$user_email, 'title' => 'Thank you for signing up with GPTS','loginlink'=>$request->base_url);
                
                Mail::send('emails.signup', $data, function($message) use($user_email, $siteEmail, $user_name) {
                    $message->to($user_email, $user_name)->subject('Student Signup Successfully.');
                    $message->from($siteEmail, 'GPTS Admin');
                });

            endif;
            
            //Login User
            try {
                $credentials = array('email' => $request->email, 'password' => $request->password);
                if (!Auth::attempt($credentials))
                    return response()->json([
                                'message' => ['Invalid email and password'],
                                'status_code' => 401,
                                    ], 401);
                $user = $request->user();
                $tokenGen = time() . 'Auth@#789' . rand(4, 100);
                $tokenResult = $user->createToken($tokenGen);
                $token = $tokenResult->token;
                if ($request->remember_me)
                    $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();
                $username = explode(' ', $user_name);
                $fname = $username[0];

                return response()->json([
                            'access_token' => $tokenResult->accessToken,
                            'user_id' => $user_id,
                            'first_name'=>$request->name,
                            'lastname'=>$request->lastname,
                            'name' => $request->name,
                            'display_name' => $fname,
                            'email' => $user_email,
                            'contact' => $user_contact,
                            'skype_id' => '',
                            'usertype' => $user_usertype,
                            'is_eligible_for_dashboard' => 0,
                            'token_type' => 'Bearer',
                            'status_code' => 200,
                            'expires_at' => Carbon::parse(
                                    $tokenResult->token->expires_at
                            )->toDateTimeString()
                ]);
            } catch (Exception $e) {

                return response()->json($e->getErrors());
            }
        }
    }

    /*
      |------------------------------------------------------------------------------------
      | User Login
      |------------------------------------------------------------------------------------
      |
      | This method handles the login of users with their | validation and login credential.
      |
    */

    public function login(Request $request) {


        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                        'message' => ['Invalid email and password'],
                        'status_code' => 401,
                            ], 401);

        if (Auth::user()->status == 0)
            return response()->json([
                        'message' => ['Your account has been deactivated for now. If you want to activate your account again, So please contact to us on our official contact information'],
                        'status_code' => 401,
                            ], 401);

        if (empty(Auth::user()->password) && Auth::user()->created_by > 0)
            return response()->json([
                        'message' => ["Email id is not registered with GPTS's account."],
                        'status_code' => 401,
                            ], 401);
            
        $user = $request->user();
        $user_id = $user->id;
        $user_name = $user->name;
        $lastname=$user->lastname;
        $user_contact = $user->contact;
        $user_usertype = $user->usertype;
        $user_email = $user->email;
        $user_pic = $user->profile_pic;
        $checkEligeblity = 0;

        if ($user_usertype == 1) {

            $studentData = Student::whereUserId($user_id)->get();
            $checkEligeblity = count($studentData);
            $skypeId = ($checkEligeblity > 0) ? $studentData[0]->skype_id : '';
        } else {

            $CollegeData = College::whereUserId($user_id)->get();
            $checkEligeblity = count($CollegeData);
            $skypeId = ($checkEligeblity > 0) ? $CollegeData[0]->skype_id : '';
        }
        $username = explode(' ', $user_name);
        $fname = $username[0];
        $tokenGen = time() . 'Auth@#789' . rand(4, 100);
        $tokenResult = $user->createToken($tokenGen);
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'user_id' => $user_id,
                    'name' => $user_name,
                    'display_name' => $fname,
                    'lastname'=>$lastname,
                    'email' => $user_email,
                    'profilepic' => (!empty($user_pic)) ? url('/public/web/userprofilepic/' . $user_pic) : '',
                    'contact' => $user_contact,
                    'skype_id' => $skypeId,
                    'is_eligible_for_dashboard' => $checkEligeblity,
                    'usertype' => $user_usertype,
                    'status_code' => 200,
                    'expires_at' => Carbon::parse(
                            $tokenResult->token->expires_at
                    )->toDateTimeString()
        ]);
    }

    /*
      |--------------------------------------------------------------------------
      | User Forgot Password
      |--------------------------------------------------------------------------
      | This method will handles the forget password request by user
      |
    */

    public function forgotPassword(Request $request) {

        //print_r($request->all());die();
        try {

            $validator = Validator::make($request->all(), [
                        'email' => 'required|email',
            ]);
            if ($validator->fails()) {

                $errorAll = array();
                foreach ($validator->errors()->getMessages() as $key => $error) {
                    $errorDb = array();
                    $errorDb[$key] = $error[0];
                    $errorAll[] = $errorDb;
                }
                return response()->json(['message' => $errorAll, 'status_code' => 401], 401);
            } else {
                $setting = Setting::first();
                $checkemail = User::where(['email' => $request->email])->get();
                if (count($checkemail) > 0) {
                    $recipientName = $checkemail[0]->name;
                    $recipient = $request->email;
                    $autogeneratePassword = str_random(8);
                    $password = Hash::make($autogeneratePassword);
                    User::where(['email' => $recipient])->update(['password' => $password]);
                    $siteEmail = $setting->robot_email;
                    // Mail Funtinality Will Be Implmented Here		
                    $data = array('name' => $recipientName, 'password' => $autogeneratePassword, 'title' => 'Change Password');
                    Mail::send('emails.resetpassword.passwordreset', $data, function($message) use($recipient, $siteEmail, $recipientName) {
                        $message->to($recipient, $recipientName)->subject('Your password has been changed.');
                        $message->from($siteEmail, 'GPTS Admin');
                    });
                    return response()->json(['msg' => 'Your password is successfully sent to your registers email id.', 'code' => '200']);
                } else {
                    return response()->json(['msg' => 'Email id is not registered!', 'code' => '403']);
                }
            }
        } catch (Exception $e) {

            return response()->json($e->getErrors());
        }
    }

    public function dashboard() {

        echo 'hellloooo';
    }

    /*
      |--------------------------------------------------------------------------
      | Logout user (Revoke the token)
      |--------------------------------------------------------------------------
      | @return [string] message
      |
    */

    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /*
      |--------------------------------------------------------------------------
      | Get the authenticated User
      |--------------------------------------------------------------------------
      | @return [json] user object
      |
    */

    public function user(Request $request) {
        return response()->json($request->user());
    }

    /*
      |--------------------------------------------------------------------------
      | Edit user's profile pic
      |--------------------------------------------------------------------------
      | @return [json] user object
      |
    */

    public function updateProfilePic(Request $request) {

        try {

            $data = $request->all();
            $data = $data['file'];
            $datetime = date("Y-m-d h:i:s");
            $timestamp = strtotime($datetime);
            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);
            $filename = $timestamp . '.png';
            $upload = User::whereId($request->user_id)->update(['profile_pic' => $filename]);
            if (file_put_contents(public_path('/web/userprofilepic/' . $filename), $data)) {
                return response()->json(['code' => '200', 'message' => 'Profile pic uploaded successfully!']);
            } else {
                return response()->json(['code' => '403', 'message' => 'Something went wrong! Please try again.']);
            }
        } catch (\Laracasts\Validation\FormValidationException $e) {
            
        }
    }
    /*
      |--------------------------------------------------------------------------
      | Chnage password
      |--------------------------------------------------------------------------
      | @return [json] user object
      |
    */
    public function changePassword(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                        'user_id' => 'required',
                        'current_password' => 'required',
                        'new_password' => 'required',
                        'confirm_password' => 'required_with:password|same:new_password'
            ]);
            if ($validator->fails()) {
                return response()->json(['msg' => $validator->errors()->all(), 'code' => '500']);
            } else {
                $user = User::whereId($request->user_id)->first();
                if (!(Hash::check($request->get('current_password'), $user->password))) {
                    // The passwords matches
                    return response()->json(['msg' => 'Your current password does not matches with the password you provided. Please try again.', 'code' => '500']);
                }

                if (strcmp($request->get('current_password'), $request->get('new_password')) == 0) {
                    //Current password and new password are same
                    return response()->json(['msg' => 'New Password cannot be same as your current password. Please choose a different password', 'code' => '500']);
                }
                //Change Password
                $user->password = bcrypt($request->get('new_password'));
                $user->save();

                return response()->json(['code' => '200', 'message' => 'Password changed successfully !']);
            }
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return response()->json($e->getErrors());
        }
    }

}
