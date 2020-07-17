<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Setting;
use App\Provider;
use App\Helpers\Helper;
use Dirape\Token\Token;
use App\EmailTemplate;
use App\SchoolType;
use App\School;
use App\LicenceCode;
use URL;
use Auth;
use Hash;
use Mail;
use Config;
use View;
use Excel;




class SchoolController extends Controller {

    use AuthenticatesUsers;

    private $userRole;
    private $userPermission;

    public function __construct() {
        View::composers([
            'App\Composers\DefaultComposer' => ['admin.layouts.header', 'admin.layouts.footer', 'emails.header']
        ]);
        $this->middleware(function ($request, $next) {
            $this->userRole = Auth::user()->usertype;
            $this->userPermission = Helper::getPermission($this->userRole, Auth::user()->created_by);
            $menu = Helper::menu($this->userRole, Auth::user()->created_by);
            view()->composer('admin.layouts.header', function($view) use($menu) {
                $view->with('menu', $menu);
            });
            return $next($request);
        });
    }

    /**
     * Get School list.
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $currentPath = Route::getFacadeRoot()->current()->uri();
        $explodePath = explode('/', $currentPath);
        if (!in_array($explodePath[1], $this->userPermission)) {
            return view('admin.not-allow');
        }

        $searchKey = (isset($request->all()['Search'])) ? $request->all()['Search'] : '';
        $result = User::sortable();
        $result->where('usertype', '=', 4);
        $result->whereIn('status', [0, 1]);
        $result->where(function($query) use ($searchKey) {
            $query->where('name', 'LIKE', '%' . $searchKey . '%');
            $query->orWhere('email', 'LIKE', '%' . $searchKey . '%');
        });
        $result->orderBy('name', 'ASC');
        $schools = $result->paginate(20);

        return view('admin.school.index', compact('schools'));
    }

    /*
      |--------------------------------------------------------------------------
      | Add School
      |--------------------------------------------------------------------------
      |
     */

    public function add(Request $request) {
        
        $currentPath = Route::getFacadeRoot()->current()->uri();
        $explodePath = explode('/', $currentPath);
        if (!in_array($explodePath[1], $this->userPermission)) {
            return view('admin.not-allow');
        }
        // Check user permission
        $menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
        if ($menupermission['add'] == 'No') {
            return view('admin.not-allow');
        }

        // Redirect to  course view
        $schooltype = Helper::getSchoolType();
        return view('admin.school.add', compact('schooltype'));
    }

    /*

     * Save school
     * @return \Illuminate\Http\Response
     *   
     */

    public function save(Request $request) {
       // echo $request->email;die();
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|unique:users|email',
                'contact' => 'unique:users',
                'address' => 'required'
            ]);

            $user = new User;
            $user->name = $request->name;
            $user->username = $request->name;
            $user->email = $request->email;
            $user->contact = $request->contact;
            $password = str_random(8);
            $user->password = Hash::make($password);
            $user->created_by = Auth::user()->id;
            $user->usertype = 4;
            $user->created_at = date('Y-m-d h:i:s');
            $user->save();
            $userId = $user->id;
            if ($userId) {
                $school                         = new School;
                $school->school_id              = $userId;
                $school->addess                 = $request->addess;
                $school->school_type            = $request->school_type;
                $school->management_name        = $request->management_name;
                $school->management_email       = $request->management_email;
                $school->management_designation = $request->management_designation;
                $school->contact_pre_name       = $request->contact_pre_name;
                $school->contact_pre_phn_no     = $request->contact_pre_phn_no;
                $school->contact_pre_email      = $request->contact_pre_email;
                $school->addess                 = $request->address;
                $school->created_at             = date('Y-m-d h:i:s');
                $school->save();
            }
            $setting = Setting::first();
            $siteEmail = $setting->robot_email;
            $recipientName = $request->fullname;
            $recipient = $request->email;
            $data = array('name' => $request->name, 'title' => 'Registration with gpts');
            Mail::send('emails.freelancer.welcomemail', $data, function($message) use($recipient, $siteEmail, $recipientName) {
                $message->to($recipient, $recipientName)->subject('Your registration is confirmed.');
                $message->from($siteEmail, 'Gpts');
            });
            return back()->with('success', 'Successfully Added !!');
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    /*
      |--------------------------------------------------------------------------
      | edit School
      |--------------------------------------------------------------------------
      |
     */

    public function show($id) {
        $menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
        if ($menupermission['edit'] == 'No') {
            return view('admin.not-allow');
        }
        $school = User::with('SchoolDetail')
                ->whereHas('SchoolDetail', function($query) use ($id) {
                    $query->whereSchool_id($id);
                })
                ->whereId($id)
                ->first();
        $schooltype = Helper::getSchoolType();
        return view('admin.school.edit', compact('school', 'schooltype'));
    }

    /*

     * Update school
     * @return \Illuminate\Http\Response
     *   
     */

    public function edit(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'contact' => 'numeric|min:10|unique:users,contact,' . $id,
            'email' => 'required|unique:users,email,' . $id,
            'address' => 'required'
        ]);

        try {
            $user = User::find($id);
            $user->name = $request->name;
            $user->username = $request->name;
            $user->email = $request->email;
            $user->contact = $request->contact;
            $user->usertype = 4;
            $user->save();
            $userId = $id;
            if ($userId) {
                $school = School::whereSchool_id($userId)->first();
                $school->school_id = $userId;
                $school->addess = $request->addess;
                $school->school_type = $request->school_type;
                $school->management_name = $request->management_name;
                $school->management_email = $request->management_email;
                $school->management_designation = $request->management_designation;
                $school->addess                 = $request->address;
                $school->contact_pre_name = $request->contact_pre_name;
                $school->contact_pre_phn_no = $request->contact_pre_phn_no;
                $school->save();
            }
            return back()->with('success', ' Updated Successfully.');
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
            School::whereSchool_id($id)->delete();
            User::find($id)->delete();
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return $e->getErrors();
        }
        return back()->with('success', 'Deleted Successfully !!');
    }

    // Generate Dynamic Code For Licence
    public function generateLicenceCode(){

        $array =array();
        for($i=0;$i<=1000;$i++){

            $string = 'GPTS'.'-'.$this->random(4).'-'.$this->random(4).'-'.$this->random(4);
            if ($this->checkExistLicenceCode($string)) {
                return generateLicenceCode();
            }else{
                $save = new LicenceCode();
                $save->licence_code = $string;
                $save->created_at = date('Y-m-d h:i:s');
                $save->save();
            }
            
        }

    }

    public function random($length, $chars = '')
    {
        if (!$chars) {
            $chars = implode(range('A','F'));
            $chars .= implode(range('0','9'));
        }
        $shuffled = str_shuffle($chars);
        return substr($shuffled, 0, $length);

    }

    public function checkExistLicenceCode($code){
        LicenceCode::whereLicenceCode($code)->exists();
    }

    /**
     * Assign code to school
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    function assignCode(){
        
        $result = User::select('id', 'name');
        $result->where('usertype', '=', 4);
        $result->whereIn('status', [1]);
        $result->orderBy('name', 'ASC');
        $schools = $result->get();

        return view('admin.school.assigncode', compact('schools'));
    }
    
    public function saveAssignCode(Request $request){
        
        /*$path="/var/www/html/cdap/backend/public/excel-folder/Siddharth International Public School-LicenceCode-1574838527.xlsx";
        
        $data = array('school'=>"Test",'contactPerson' => "Lakhan Bisht",'title'=>'Registration with gpts','loginlink' => 'www.google.com');
        
        Mail::send('emails.liciencecode', $data, function($message) use($path){
            $message->to("lakhan@greatplacetostudy.org", "Lakhan Bisht")->subject('Your registration is confirmed.');
            $message->from('no-reply@greatplacetostudy.com','Gpts');
            $message->attach($path);
        });

        die();
        */
        $school         =   $request->school;
        $number         =   $request->number;
        $schoolinfo     =   User::select('users.name','gpts_school.management_name', 'gpts_school.management_email')
                            ->join('gpts_school','gpts_school.school_id','=','users.id')
                            ->where('users.id','=',$school)
                            ->first();
        $contactPerson  =   $schoolinfo->management_name;
        //return view('emails.liciencecode', compact('school', 'contactPerson'));
       // die();
        $assignCode     =   LicenceCode::select('id')
                            ->where('school_assign', '=', 0)
                            ->OrderBy('id', 'ASC')
                            ->limit($number)->get();
        $update         =   LicenceCode::whereIn('id',$assignCode)->update(['school_assign' => $school, 'school_assign_date' => date('Y-m-d h:i:s')]);
        
        // Excel Export
        $exportFileName =   $schoolinfo->name.'-LicenceCode-'.time();
        $path = getcwd().'/public/excel-folder/'.$exportFileName.'.xlsx';

        Excel::create($exportFileName, function($excel) use ($assignCode) {

            // Set the title
            //$excel->setTitle('My awesome report 2016');
            // Chain the setters
            // $excel->setCreator('Me')->setCompany('Our Code World');
            //$excel->setDescription('A demonstration to change the file properties');
            $defaultData    = ['Autogenerated Licence Code'];
            $allData[] = $defaultData;
            $getcode = LicenceCode::select('licence_code')->whereIn('id',$assignCode)->get();
            foreach($getcode as $key){
                $allData[] = [$key->licence_code];
            }
            $excel->sheet('Sheet 1', function ($sheet) use ($allData) {
                $sheet->setOrientation('landscape');
                $sheet->fromArray($allData, NULL, 'A0');
            });

        })->store('xlsx', public_path('excel-folder'));

        // Sent autogenerated code file to school

        //sleep(10);
        
        $setting = Setting::first();
		$siteEmail = $setting->robot_email;
		$recipientName  = $schoolinfo->management_name;
        $recipient  	= $schoolinfo->management_email;
        //$recipientName  = 'Anchal';
		//$recipient  	= 'anchal@greatplacetostudy.org';
        
		$data = array('school'=>$schoolinfo->name,'contactPerson' => $contactPerson,'title'=>'Registration with gpts','loginlink' => 'www.google.com');
		
        Mail::send('emails.liciencecode', $data, function($message) use($path, $recipient,$recipientName){
			$message->to($recipient, $recipientName)->subject('Your registration is confirmed.');
            $message->from('no-reply@greatplacetostudy.com','Gpts');
            $message->attach($path);
		});

        return back()->with('success', 'Assign Successfully.');
    }
}
