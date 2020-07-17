<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Setting;
use App\Usermeta;
use App\Provider;
use App\Helpers\Helper;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Dirape\Token\Token;
use URL;
use App\UserType;
use Auth;
use Hash;
use Mail;
use Config;
use App\EmailTemplate;
use View;

class UserController  extends Controller
{
	
		use AuthenticatesUsers;
		private $userRole;
		private $userPermission;
	
public function __construct(){
	View::composers([
		'App\Composers\DefaultComposer' => ['admin.layouts.header', 'admin.layouts.footer', 'emails.header']
	]);
	$this->middleware(function ($request, $next) {
		$this->userRole = Auth::user()->usertype;
		$this->userPermission = Helper::getPermission($this->userRole, Auth::user()->created_by);
		$menu = Helper::menu($this->userRole, Auth::user()->created_by);
		view()->composer('admin.layouts.header', function($view) use($menu)
		{
			$view->with('menu', $menu);
		});
		return $next($request);
	});	
}


public function adminUser(Request $request){
	if(!in_array('user',$this->userPermission)){
		return view('admin.not-allow');	
	}
	$searchKey 	= (isset($request->all()['Search']))?$request->all()['Search']:'';
	$query	 	= User::sortable();
				$query->where('usertype','>',11);
				if(Auth::user()->usertype != 11){$query->whereCreatedBy(Auth::user()->id);}
				$query->orderBy('created_at','Desc');
	$user		= $query->paginate(20);			
	
	return view('admin.user.index',compact('user'));
}	

	
public function add(){
		
	$state = State::select('id','name as state')->where('country_id','=',101)->orderBy('name','ASC')->get();
	$customer_type = CustomerType::get();
	return view('admin.customer.add')->with(['state'=>$state,'customer_type'=>$customer_type]);
}
	
public function addUser(){
		$usertype = UserType::get();
			$usertypelist =array();
			foreach($usertype as $index=> $value){
				if($value['type'] != 'Super Admin'){
					if($value['id'] != Auth::user()->usertype){
						$usertypelist[$value['id']] = $value['type'];
					}
					
				}
				
			}
	return view('admin.user.add',  compact('usertypelist'));
}
 /**
 * Display the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function show($id) {
	$user = User::find($id);
	$userMeta = Usermeta::where('user_id', $id)->first();
	$state = State::select('id','name as state')->where('country_id','=',101)->orderBy('name','ASC')->get();

	$citylist=Provider::select('id','name as cityname','state_id')->where(['state_id' => $userMeta->region])->orderBY('name','ASC')->get();
	
	$customer_type = CustomerType::get();
	
	return view('admin.customer.view')->with(['user' => $user, 'userMeta'=>$userMeta,'state'=>$state,'customer_type'=>$customer_type,'citylist'=>$citylist]);
}
	
public function showuser($id) {
	$user = User::find($id);
			$usertype = UserType::get();
			$usertypelist =array();
			foreach($usertype as $index=> $value){
			   // $data['name'] = $value['type']; 
				$usertypelist[$value['id']] = $value['type'];
			}
	return view('admin.user.view')->with(['user' => $user,'usertypelist'=>$usertypelist]);
}

/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function store(Request $request) {
	try {
		$this->validate($request, [
		'fullname' 	=> 'required',
		'email' 		=> 'required|unique:users|email',
		'contact_no' 	=> 'required|numeric|min:10',
		'role' 	=> 'required',
		]);
	} catch (\Laracasts\Validation\FormValidationException $e) {
		return Redirect::back()->withInput()->withErrors($e->getErrors());
	}
	$user = new User;
	$user->name 	= $request->fullname;
	$user->email 		= $request->email;
	$user->contact 	= $request->contact_no;
	$password 			= str_random(8);
	$user->password 	= Hash::make($password);
	$user->usertype 	= $request->role;
	$user->created_by	= Auth::user()->id;
	$user->status 		= $request->status;
	$user->created_at 	= date('Y-m-d h:i:s');
	$user->save();
	$userId = $user->id;
	if($userId){	
	// $usermeta = new Usermeta;
	// $usermeta->user_id 		= $userId;
	// $usermeta->save();
		// Mail Funtinality Will Be Implmented Here	
		$setting = Setting::first();
		$siteEmail = $setting->robot_email;
		$recipientName  = $request->fullname;
		$recipient  	= $request->email;
		$adduserrole = $this->getRoleName($this->userRole);
		$userrole = $this->getRoleName($request->role);
		$data = array('name'=>$request->fullname,'password'=>$password,'email'=>$request->email,'adduserrole'=>$adduserrole,'userrole'=>$userrole,'title'=>'Registration with gpts');
		Mail::send('emails.freelancer.registration', $data, function($message) use($recipient, $siteEmail, $recipientName){
			$message->to($recipient, $recipientName)->subject('Your registration is confirmed.');
			$message->from($siteEmail,'Gpts');
		});
	}
	return back()->with('success', 'A new user added successfully.');
}
/**
 * Show the form for editing the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function edit(Request $request, $id) {

	$this->validate($request, [

		'name' 		=> 'required',
		'contact' 	=> 'required|numeric|min:10|unique:users,contact,'.$id,
		//'email' => 'required|unique:users,email,'. $id,
		'role' 		=> 'required',

	]);

	try {
		$user = User::find($id);
		$user->name 	= $request->name;
		$user->contact 	= $request->contact;
		$user->status 	= 1;
		$user->email	= $request->email;
			if($user->usertype!=$request->role){
				
				$setting = Setting::first();
				$emailTemplate = EmailTemplate::select('subject','body')->where('slug','user-role-change-template')->first();
				$siteEmail = $setting->robot_email;
				$siteName = $setting->site_name;
				$adminEmail = $setting->admin_email;
				$recipientName = $user->name;
				$recipient = $user->email;
				$adduserrole = $this->getRoleName($this->userRole);
				$userrole = $this->getRoleName($request->role);
				$adminName = Config::get('constants.ADMINNAME');
				$repConts = ['[Admin-Name]','[User-Role]','[Admin-Role]', '[User-Name]', '[User-Email]'];
				$repcontswith = [$adminName,$userrole,$adduserrole,$user->fullname,$user->email];
					
				/*user email*/
				$emailTemplate['body'] = str_replace($repConts, $repcontswith, $emailTemplate['body']);
				$emailTemplate['subject'] = str_replace($repConts, $repcontswith, $emailTemplate['subject']);	
				$data = array('body'=>$emailTemplate['body'],'title'=>'Change done in Gpts admin panel');
				$subject = $emailTemplate['subject'];
				Mail::send('emails.mail', $data, function($message) use($recipient, $siteEmail, $recipientName,$subject){
				$message->to($recipient, $recipientName)->subject($subject);
				$message->from($siteEmail,'Gpts Admin');
				});
			/*End Email*/
			}
		 $user->usertype = $request->role;
		 $user->save();

		// $usermeta = Usermeta::where('user_id', $id)->first();
		// $usermeta->region 		= $request->region;
		// $usermeta->city 		= $request->city;
		// $usermeta->postcode 	= $request->postcode;
		// $usermeta->company_name = $request->company_name;
		// $usermeta->gsitn 	    = $request->gsitn;
		// $usermeta->customer_type = $request->customer_type;
		// $usermeta->address 		= $request->address;
		// $usermeta->save();
	
		return back()->with('success', 'User Profile Updated Successfully.'); 
	} catch (\Laracasts\Validation\FormValidationException $e) {
		return Redirect::back()->withInput()->withErrors($e->getErrors());
	}
	
}
	
/**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
 
public function destroy($id) {
	try {
		$user = User::find($id)->delete();
		$userMeta = Usermeta::where('user_id', $id)->delete();
	} catch (\Laracasts\Validation\FormValidationException $e) {
		return $e->getErrors();
	}
	return redirect('admin/user')->with('success', 'User Deleted Successfully.'); 
}


public function getRoleName($role){
	$usertype = UserType::whereId($role)->first();
	return $usertype->type;
}

	
		
}	
