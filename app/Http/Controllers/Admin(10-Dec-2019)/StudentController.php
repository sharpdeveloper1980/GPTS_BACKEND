<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Setting;
use App\Usermeta;
use App\Provider;
use App\Helpers\Helper;
use Dirape\Token\Token;
use App\EmailTemplate;
use App\UserType;
use App\Student;
use App\Sop;
use App\SopAnswer;
use URL;
use Auth;
use Hash;
use Mail;
use Config;
use View;

class StudentController  extends Controller
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

    /*
    |------------------------------------------------------------------------------------
    | Student's List
    |------------------------------------------------------------------------------------
    |
    | This method handles the list of for all students.
    |
    */
    public function students(Request $request){

        if(!in_array('students',$this->userPermission)){
            return view('admin.not-allow');	
        }
        $type = 'all';
        $searchKey 	=   (isset($request->all()['Search']))?$request->all()['Search']:'';
        $result	 	=   User::sortable();
                        $result->where('usertype','=',1);
                        $result->where(function($query) use ($searchKey)
                        {
                            $query->where('name','LIKE','%'.$searchKey.'%');
                            $query->orWhere('email','LIKE','%'.$searchKey.'%');
                            $query->orWhere('contact','LIKE','%'.$searchKey.'%');
                        });
                        $result->orderBy('name','ASC');
        $count      = $result->count();
        $students   =   $result->paginate(20);
        foreach ($students as $key => $value) :
            $value['sop_question'] = SopAnswer::where('user_id', $value['id'])->where('sopid','!=',2)->count();
            $value['sop_video'] = SopAnswer::where('user_id', $value['id'])->where('sopid','=',2)->count();
            $students[$key] = $value;
        endforeach;
        return view('admin.student.index',compact('students', 'count', 'type'));

    }
    /*
    |------------------------------------------------------------------------------------
    | Student's List for active and inactive status
    |------------------------------------------------------------------------------------
    |
    | This method handles the list of for all students.
    |
    */
    public function filterStudents(Request $request, $type){

        if(!in_array('students',$this->userPermission)){
            return view('admin.not-allow');	
        }

        if( $type == 'tte' ){

            $searchKey 	=   (isset($request->all()['Search']))?$request->all()['Search']:'';
            $result	 	=   User::sortable()->select('users.*', 'tte_users.pdf_report as pdfreport');
                            $result->Join('tte_users', 'tte_users.student_id', '=', 'users.id');
                            // $result->where('users.status',1);
                            $result->orderBy('name','ASC');
            $count      = $result->count();
            $students   =   $result->paginate(20);


        }else{


                $searchKey 	=   (isset($request->all()['Search']))?$request->all()['Search']:'';
                $result	 	=   User::sortable();
                                if($type != 'active' && $type != 'inactive' && $type != ''){
                                    $result->Join('gpts_licence_code', 'gpts_licence_code.student_assign', '=', 'users.id');
                                    $result->where('gpts_licence_code.school_assign','=',179);
                                }
                                $result->where('usertype','=',1);
                                $result->where(function($query) use ($searchKey)
                                {
                                    $query->where('name','LIKE','%'.$searchKey.'%');
                                    $query->orWhere('email','LIKE','%'.$searchKey.'%');
                                    $query->orWhere('contact','LIKE','%'.$searchKey.'%');
                                });
                                if($type == 'active'){$result->whereStatus(1);}else if($type == 'inactive'){$result->whereStatus(0);}
                                $result->orderBy('name','ASC');
                $count      = $result->count();
                $students   =   $result->paginate(20);

           
        }
        
        return view('admin.student.index',compact('students', 'type', 'count'));
    }
        
    public function textSop(){

        if(!in_array('text-sop',$this->userPermission)){
            return view('admin.not-allow');	
        }

        $result = Sop::whereId(1)->first();
        return view('admin.sop.sop', compact('result'));
    }

    public function videoSop(){
        
        if(!in_array('video-sop',$this->userPermission)){
            return view('admin.not-allow', compact('result'));	
        }

        $result = Sop::whereId(2)->first();
        return view('admin.sop.sop', compact('result'));
    }

    public function editSop(Request $request, $id){
    
        $query              =   Sop::find($id);
        $query->question    =   $request->question;
        $query->save();
        return back()->with('success', 'SOP Successfully updated.');
    }

    public function studentView($id) {
        $country = Helper::getCountry();
        $state = Helper::getState();
        $student = User::select('users.name','users.email','users.contact','users.profile_pic','users.status','gpts_student.*')->leftJoin('gpts_student', 'gpts_student.user_id', '=', 'users.id')->where('users.id',$id)->first();
        $student['prefferred_location'] = json_decode($student['prefferred_location']);
        $student['grade_in_cgpa'] = json_decode($student['grade_in_cgpa']);
        $student['per_in_class'] = json_decode($student['per_in_class']);
        $student['honors_group'] = json_decode($student['honors_group']);
        return view('admin.student.edit', compact('student','country','state'));

    }

    public function updateStaudent($type,$id) {
        $student = Student::find($id);
        if($type=='dob'){
        
            $student->$type = '0000-00-00';
        }else if($type=='contact'){
            $user = User::whereId($student->user_id)->first(); 
            $user->contact = '';
            $user->save();
        } else{
        $student->$type = '';
        }
        $student->save();
        return back()->with('success', 'Deleted Successfully !!');
    }

    public function getsopanswer($type,$user_id) {
            $sop = Sop::with('sopAnswer')
        ->whereHas('sopAnswer', function($query) use ($user_id) {
            $query->whereUserId($user_id);
        })
        ->whereSopType($type)
        ->get();
        if($type=='video'){
            return view('admin.student.sopvideolist', compact('sop'));     
        }else{
            return view('admin.student.soplist', compact('sop'));   
        }
        
    }

    public function deleteSopVideo($filename,$id) {
        $path= public_path('/sop');
        unlink($path.'/'.$filename);
        SopAnswer::whereId($id)->delete();
            return back()->with('success', 'Deleted Successfully !!');
    }

    public function deleteSopText($id) {
        SopAnswer::whereId($id)->delete();
            return back()->with('success', 'Deleted Successfully !!');
    }
		
}	
