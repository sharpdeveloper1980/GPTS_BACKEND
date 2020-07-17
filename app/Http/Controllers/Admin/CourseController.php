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
use App\CollegeType;
use App\College;
use App\CollegeProminent;
use App\CollegeFaculties;
use App\CollegeAlumni;
use App\CollegeGallery;
use App\CollegeScolarship;
use App\CollegeWhyChoose;
use App\CollegeCourse;
use Auth;
use Hash;
use Mail;
use Config;
use App\EmailTemplate;
use View;
use Illuminate\Support\Facades\Route;

class CourseController extends Controller {

    use AuthenticatesUsers;

    private $userRole;
    private $userPermission;

    public function __construct() {
        View::composers([
            'App\Composers\DefaultComposer' => ['admin.layouts.header', 'admin.layouts.footer', 'emails.header']
        ]);
        // Set User Permission
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
     * Display the collage list.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id) {

        $collegename = User::select('name')->whereId($id)->first();
        $searchKey = (isset($request->all()['Search'])) ? $request->all()['Search'] : '';
        $query = CollegeCourse::where('college_id', $id);
        $query->where('name', 'LIKE', '%' . $searchKey . '%');
        $query->orderBy('name', 'Desc');
        $course = $query->paginate(20);

        return view('admin.course.index', compact('course', 'collegename'));
    }

    /*
      |--------------------------------------------------------------------------
      | Add Collage Course
      |--------------------------------------------------------------------------
      |
     */

    public function addCourse(Request $request) {

        // Check user permission
        $currentPath = Route::getFacadeRoot()->current()->uri();
        $explodePath = explode('/', $currentPath);
        if (!in_array($explodePath[1], $this->userPermission)) {
            return view('admin.not-allow');
        }

        // Redirect to  course view
        $college = Helper::getCollege();
        return view('admin.course.add', compact('college'));
    }

    /*
      |--------------------------------------------------------------------------
      | Svae College Course
      |--------------------------------------------------------------------------
      |
     */

    public function saveCourse(Request $request) {

        try {

            $this->validate($request, [
//                'name' => 'required',
            ]);

//            $course = new CollegeCourse;
//            $course->college_id = $request->college_id;
//            $course->name = $request->name;
//            $course->about = $request->about;
//            $course->admission_system = $request->admission_system;
//            $course->duration = $request->duration;
//            $course->eligibility_criteria = $request->eligibility_criteria;
//            $course->entrance_exam = $request->entrance_exam;
//            $course->deadline = $request->deadline;
//            $course->exam_fees = $request->exam_fees;
//            $course->tuition_fees = $request->tuition_fees;
//            $course->session = $request->session;
//            $course->pinfo = $request->pinfo;
            $alumni = array();
            foreach ($request->rfaculties as $key => $value) :

                $img = '';
                if (isset($_FILES['renowned_img']['name'][$key]) && $_FILES['renowned_img']['name'][$key] != ''):
                    $imgname = time() . '_' . $_FILES['renowned_img']['name'][$key];
                    $destinationPath = public_path('/image/renowned_faculties/') . $imgname;
                    move_uploaded_file($_FILES['renowned_img']['tmp_name'][$key], $destinationPath);
                    $img = $imgname;
                else:
                    $img = '';
                endif;
                $alumni[] = array(
                    'path' => $img,
                    'text' => $value,
                );

            endforeach;
            $coursedata = array();
            foreach ($request->name as $key => $value) :
                //if ($value != ''):
                $coursedata[] = array(
                    'college_id' => $request->college_id,
                    'name' => $value,
                    'about' => $request->college_id,
                    'admission_system' => $request->admission_system,
                    'duration' => $request->duration,
                    'eligibility_criteria' => $request->eligibility_criteria,
                    'entrance_exam' => $request->entrance_exam,
                    'deadline' => $request->deadline,
                    'exam_fees' => $request->exam_fees,
                    'tuition_fees' => $request->tuition_fees,
                    'session' => $request->session,
                    'pinfo' => $request->pinfo,
                    'exam_accept' => $request->exam_accept,
                    'rfaculties' => json_encode($alumni),
                );
                //endif;
            endforeach;
           
            CollegeCourse::insert($coursedata);


            return back()->with('success', 'Successfully Saved !!');
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $course = CollegeCourse::find($id);
        $course['rfac'] = json_decode($course->rfaculties);
        $college = Helper::getCollege();
        return view('admin.course.edit', compact('course', 'college'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {
        try {

            $this->validate($request, [
                'name' => 'required',
            ]);
            $course = CollegeCourse::find($id);
            $course->college_id = $request->college_id;
            $course->name = $request->name;
            $course->about = $request->about;
            $course->admission_system = $request->admission_system;
            $course->duration = $request->duration;
            $course->eligibility_criteria = $request->eligibility_criteria;
            $course->entrance_exam = $request->entrance_exam;
            $course->deadline = $request->deadline;
            $course->exam_fees = $request->exam_fees;
            $course->tuition_fees = $request->tuition_fees;
            $course->session = $request->session;
            $course->pinfo = $request->pinfo;
            $course->exam_accept = $request->exam_accept;
            $alumni = array();
            foreach ($request->rfacult as $key => $value) :

                $img = '';
                if (isset($_FILES['renowned_img']['name'][$key]) && $_FILES['renowned_img']['name'][$key] != ''):
                    $imgname = time() . '_' . $_FILES['renowned_img']['name'][$key];
                    $destinationPath = public_path('/image/renowned_faculties/') . $imgname;
                    move_uploaded_file($_FILES['renowned_img']['tmp_name'][$key], $destinationPath);
                    $img = $imgname;
                else:
                    $img = $request->re_img[$key];
                endif;
                $alumni[] = array(
                    'path' => $img,
                    'text' => $value,
                );

            endforeach;
            $course->rfaculties = json_encode($alumni);
            $course->save();
            return back()->with('success', 'Successfully Updated !!');
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
            CollegeCourse::find($id)->delete();
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return $e->getErrors();
        }
        return back()->with('success', 'Deleted Successfully !!');
    }
    
    
    public function getCourseName(Request $request) {
        $coursename = CollegeCourse::where('college_id',$request->college_id)->whereName($request->coursename)->first();
        if($coursename!=''):
            return response()->json(['code'=>'200','msg'=>'Course name already taken']);
         else:
            return response()->json(['code'=>'500','msg'=>'']);
        endif;
    }

}
