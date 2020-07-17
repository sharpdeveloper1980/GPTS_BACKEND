<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Setting;
use App\State;
use App\CustomerType;
use App\Usermeta;
use App\Provider;
use App\UserType;
use App\Helpers\Helper;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Dirape\Token\Token;
use URL;
use Auth;
use Hash;
use Mail;
use View;

class LoginController extends Controller
{
		//	private $userRole;
	
	public function __construct(){

         View::composers([
            'App\Composers\DefaultComposer' => ['admin.login']
        ]);

    }
    /**
     * Display a login page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.login');
    }
	/**
     * Check user authentication for login.
     *
     * @return \Illuminate\Http\Response
     */
	public function userAuth(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|email',
			'password' => 'required',
		]);

		if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')]))
		{
			$user = auth()->user();
			$role = UserType::select('id')->get();
			$roleArray = array();
			foreach($role as $keyVal){
				array_push($roleArray, $keyVal->id);
			}
			//print_r($roleArray);die();
			if(in_array(auth()->user()->usertype, $roleArray)){
				return redirect('admin/dashboard');
			}else{
				return back()->with('error', 'You are not allowed to login in admin panel');
			}
		}else{
			$request->session()->flash('error', 'Please login with valid credential!');
			return view('admin.login');
		}
	}

	public function doLogout()
	{
		auth()->logout(); // log the user out of our application
		return redirect('administrator'); // redirect the user to the login screen
	}
	
	/**
		 * User Forgot Password Screen. 
		 *
		 * @param  int  $email
		 * @return \Illuminate\Http\Response
		 */
		
		public function forgotPassword(Request $request){
							
				return view('admin.forgot-password');
		
		}
		
		
		/**
		 * Send Token To Mail For Forgot Password. 
		 *
		 * @param  int  $email
		 * @return \Illuminate\Http\Response
		 */
		
		public function sendResetPasswordToken(Request $request){
			//die();
			$setting = Setting::first();
			$request->session()->flash('success', '');				
			$this->validate($request, ['email' => 'required|email']);
			$checkemail = User::where(['email' => $request->email])->get();
		//	print_r($checkemail);die();
			if(count($checkemail) > 0){
				$recipientName = $checkemail[0]->fullname;
				$recipient = $request->email;
				$autogeneratePassword = str_random(8);
				
				$password = Hash::make($autogeneratePassword);
			//	print_r($autogeneratePassword);die();
				User::where(['email' => $recipient])->update(['password' => $password]);
//				$url = URL::to('/admin/reset-password').'/'.$token;
				$siteEmail = $setting->robot_email;
				// Mail Funtinality Will Be Implmented Here		
				$data = array('name'=>$recipientName,'password'=>$autogeneratePassword,'title'=>'Reset Password');
				Mail::send('emails.resetpassword.passwordreset', $data, function($message) use($recipient, $siteEmail, $recipientName){
				 $message->to($recipient, $recipientName)->subject('Your password is successfully sent to your registers email id');
				 $message->from($siteEmail,'Crimson Admin');
				});				
				$request->session()->flash('success', 'Please check your email inbox to reset your password.');
				
			}else{
				$request->session()->flash('forgoterror', 'Email id is not registerd!');
			}
			return redirect('admin/forgot-password');
			//return view('admin.forgot-password');
		}
		
		
		/**
		 * Reset Password Token. 
		 *
		 * @param  int  $token
		 * @return \Illuminate\Http\Response
		 */
		
		public function resetPassword(Request $request){
			
			$request->session()->flash('reseterror', '');
			$token = $request->token;
			
			try {
				
				$checktoken = User::where(['reset_token' => $request->token, 'role' => 1])->get();
				if(count($checktoken) >0){
					
					if($request->password){
						
						$this->validate($request, [
							'password' => 'required|confirmed',
							'password_confirmation' => 'required'
						]);
						
						$password = Hash::make($request->password);
						$resetPassword = User::where(['reset_token' => $token])->update(['password' => $password, 'reset_token' => '']);
						if($resetPassword){
							$request->session()->flash('success', 'Your password has been updated. Please login with new password');
							return redirect('administrator');
						}else{
							return back()->with('token', $token); 
						}
						
					}else{
						
						return view('admin.reset-password')->with('token', $token);
						
					}
					
				}else{
					$request->session()->flash('reseterror', 'Invaid Token');
					return view('admin.reset-password')->with('token', $token); 
				}
				
				
			} catch (\Laracasts\Validation\FormValidationException $e) {

				return $e->getErrors();
			}
			
			
			
		}
		
		
	
}
