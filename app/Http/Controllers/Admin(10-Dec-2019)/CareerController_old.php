<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Validation\Rule;
use App\User;
use App\Setting;
use App\Usermeta;
use App\Provider;
use App\Helpers\Helper;
use Dirape\Token\Token;
use App\UserType;
use App\CollegeType;
use App\College;
use App\EmailTemplate;
use App\Career;
use App\CareerExam;
use App\CareerScholarship;
use App\CareerLibaryVideo;
use Auth;
use Hash;
use Mail;
use Config;
use URL;
use View;
use Image;

class CareerController extends Controller {

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
     * Get Career list.
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
        $query = Career::sortable();
        $query->where('name', 'LIKE', '%' . $searchKey . '%');
        $career = $query->whereDeleted(0)->whereParent(0)->orderBy('name', 'Desc')->paginate(20);
        foreach ($career as $key => $value) :
            $value['total_subcareer'] = Career::where('parent', $value['id'])->groupBy('parent')->count();
           
            $career[$key] = $value;
        endforeach;
        return view('admin.career_library.index', compact('career'));
    }
    // Sow sub career
    public function showSubCareer(Request $request,$career_id) {


        $searchKey = (isset($request->all()['Search'])) ? $request->all()['Search'] : '';
        $query = Career::sortable();
        $query->where('name', 'LIKE', '%' . $searchKey . '%');
        $career = $query->whereDeleted(0)->whereParent($career_id)->orderBy('name', 'Desc')->paginate(20);
        $careername = Career::select('name')->whereId($career_id)->first()->name;
        foreach ($career as $key => $value) :
            $value['total_exam'] = CareerExam::where('career_id', $value['id'])->groupBy('career_id')->count();
            $value['total_scholar'] = CareerScholarship::where('career_id', $value['id'])->groupBy('career_id')->count();
            $value['total_career_video'] = CareerLibaryVideo::where('career_id', $value['id'])->groupBy('career_id')->count();
            $career[$key] = $value;
        endforeach;
        return view('admin.career_library.subcareer', compact('career','careername','career_id'));
    }
    
    /**
     * Add new career library in  database storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add() {

        $currentPath = Route::getFacadeRoot()->current()->uri();
        $explodePath = explode('/', $currentPath);
        if (!in_array($explodePath[1], $this->userPermission)) {
            return view('admin.not-allow');
        }
        $college = Helper::getCollege();
        $TteIdList = Helper::getTteCareerId();
        $careerlist = Helper::getParentCareer();
        return view('admin.career_library.add', compact('college','TteIdList','careerlist'));
    }
    /*

     * save career
     *     
     */
    public function saveCareer(Request $request) {
        try {
            
            if( $request->career_type == 1 ){

                $this->validate($request, [
                    'name' => 'required',
                    'about' => 'required',
                    'slug' => 'required|unique:gpts_career_library,slug',
                    'tte_career_id' => 'required|unique:gpts_career_library,tte_career_id',
                    'career_type'=>'required'
                ]);

            }else{

                $this->validate($request, [
                    'name' => 'required',
                    'about' => 'required',
                    'slug' => 'required|unique:gpts_career_library,slug',
                    'career_type'=>'required'
                ]);

            }
            

            $related_career = array();
            $do_you_know = array();
            $competencies = array();
            $careerjobs = array();
            $query = new Career();
            $query->name = $request->name;
            $query->about = $request->about;
            $query->slug = $request->slug;
            $query->type = $request->career_type;
            $query->banner_title = $request->banner_title;
            
            if (isset($_FILES['career_icon']['name']) && $_FILES['career_icon']['name'] != ''):
                $careericon = $request->file('career_icon');
                $imgname = time() . '.' . $careericon->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = '/career/career-icon/' . $imgname;
                $s3->put($filePath, file_get_contents($careericon), 'public');
                $career_icon = $imgname; 
            else:
                $career_icon = '';
            endif;
             $query->career_icon = $career_icon;
             if (isset($_FILES['career_banner']['name']) && $_FILES['career_banner']['name'] != ''):
                $careerbanner = $request->file('career_banner');
                $imgname = time() . '.' . $careerbanner->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = '/career/career-banner/' . $imgname;
                $s3->put($filePath, file_get_contents($careerbanner), 'public');
                $career_banner = $imgname;                                
            else:
                $career_banner = '';
            endif;
             $query->career_banner = $career_banner;
             if (isset($_FILES['career_banner']['name']) && $_FILES['career_banner']['name'] != ''):
                $careerthumb = $request->file('career_banner');
                $expertimageFileName = time() . '.' . $careerthumb->getClientOriginalExtension();                
                $s3 = \Storage::disk('s3');
                $filePath = '/career/career-thumb/' . $expertimageFileName;
                $destinationPath = public_path('/thumbnail_images');
                 $thumb_img = Image::make($careerthumb->getRealPath());
                 $thumb_img->resize(300, null, function ($constraint) {
                 $constraint->aspectRatio();
                });
                $thumb_img->save($destinationPath.'/'.$expertimageFileName);

                $s3->put($filePath, file_get_contents($destinationPath.'/'.$expertimageFileName), 'public');
                unlink($destinationPath.'/'.$expertimageFileName);
                $career_thumb = $expertimageFileName;                              
            else:
                $career_thumb = '';
            endif;
             $query->career_thumb = $career_thumb;
             if($request->career_type==1){
               if (isset($_FILES['exp_video']['name']) && $_FILES['exp_video']['name'] != ''):
                $expvideo = $request->file('exp_video');
                $expvideoname = time() . '.' . $expvideo->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = '/career/career-video/' . $expvideoname;
                $s3->put($filePath, file_get_contents($expvideo), 'public');
                $exp_video = $expvideoname;                                
            else:
                $exp_video = '';
            endif;
            if (isset($_FILES['video_thumb']['name']) && $_FILES['video_thumb']['name'] != ''):
                $video_thumb= $request->file('video_thumb');
                $expthumbname = time() . '.' . $video_thumb->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = '/career/career-video/' . $expthumbname;
                $s3->put($filePath, file_get_contents($video_thumb), 'public');
                $exp_thumb_name = $expthumbname;                                
            else:
                $exp_thumb_name = '';
            endif;
             $query->exp_video = $exp_video; 
             $query->video_thumb = $exp_thumb_name; 
             $query->video_title = $request->video_title;
             $query->video_designation = $request->video_designation;
             $query->tte_career_id = $request->tte_career_id;
              foreach ($request->title_do as $key => $value) :
                 
                      $do_you_know[] = array('title' => $value, 'description' => $request->desc_do[$key]);
                            
            endforeach;
            $query->do_you_know = json_encode($do_you_know);
             }
            
           if($request->career_type==2){
            $query->parent = isset($request->parent_id)?$request->parent_id:0;
            $query->area_cover = json_encode($request->area_covers);
            $query->career_ladder = json_encode($request->career_ladder);
//            $query->undergraduate_eligibility_criteria = $request->undergraduate_eligibility_criteria;
//            $query->postgraduate_eligibility_criteria = $request->postgraduate_eligibility_criteria;
             $query->pros = $request->pros;
            $query->cons = $request->cons;
            // Save related career
            foreach ($request->related_title as $key => $value) :
               
                $related_career[] = array('title' => $value, 'description' => $request->related_desc[$key]);
            endforeach;

            $query->related_career = json_encode($related_career);
            //save competencies
             foreach ($request->competencies_title as $key => $value) :
               
                $competencies[] = array('title' => $value, 'description' => $request->competencies_desc[$key]);
            endforeach;

            $query->competencies = json_encode($competencies);
            foreach ($request->job_title as $key => $value) :
               
                $careerjobs[] = array('title' => $value, 'description' => $request->job_desc[$key]);
            endforeach;

            $query->career_jobs = json_encode($careerjobs);
            
//            $query->expected_remuneration = json_encode(array($request->beginner, $request->intermediate, $request->expertt));
//            $query->traits_in_pointers = json_encode($request->traits_pointer);

//            // Save famous Personalities
//            foreach ($request->designation as $key => $value) :
//                if (isset($_FILES['famous_img']['name'][$key]) && $_FILES['famous_img']['name'][$key] != ''):
//                    $imgname = time() . '_' . $_FILES['famous_img']['name'][$key];
//                    $destinationPath = public_path('/image/famous_img/') . $imgname;
//                    move_uploaded_file($_FILES['famous_img']['tmp_name'][$key], $destinationPath);
//                    $img = $imgname;
//                else:
//                    $img = '';
//                endif;
//                $famous_image[] = array('designation' => $value, 'famous_img' => $img);
//            endforeach;
//
//            $query->famouse_personaliities = json_encode($famous_image);

            //print_r($famous_image);die();
            //save graph and text
//            if (isset($_FILES['graph']['name']) && $_FILES['graph']['name'] != ''):
//                $imgname = time() . '_' . $_FILES['graph']['name'];
//                $destinationPath = public_path('/image/graph/') . $imgname;
//                move_uploaded_file($_FILES['graph']['tmp_name'], $destinationPath);
//                $img = $imgname;
//            else:
//                $img = '';
//            endif;            
//            $query->lies_ahead = json_encode(array('text' => $request->text, 'graph' => $img));  
            $query->prospect = $request->prospect;
            $query->salary = $request->salary;
            $query->key_psychology = $request->key_psychology;
            
//            $query->top_colleges = json_encode($request->top_college);
           }
            $query->save();
            return back()->with('success', 'Successfully Added !!');
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    public function show($id) {
        $menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
        if ($menupermission['edit'] == 'No') {
            return view('admin.not-allow');
        }

        $career = Career::whereId($id)->first();
        if($career->type==1):
          $type = 'Career';  
        else:
            $type = 'Sub Career';
        endif;
        $college = Helper::getCollege();
         $TteIdList = Helper::getTteCareerId();
        $careerlist = Helper::getParentCareer();
        return view('admin.career_library.edit', compact('career', 'college','TteIdList','careerlist','type'));
    }

    /**
     * Update the specified career detail in database storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {

        try {
            
            if( $request->career_type == 1 ){

                $this->validate($request, [
                    'name' => 'required',
                    'about' => 'required',
                    'slug' => 'required|unique:gpts_career_library,slug,'. $id,
                    'tte_career_id' => 'required|unique:gpts_career_library,tte_career_id,'. $id,
                    'career_type'=>'required'
                ]);

            }else{

                $this->validate($request, [
                    'name' => 'required',
                    'about' => 'required',
                    'slug' => 'required|unique:gpts_career_library,slug,'. $id,
                    'career_type'=>'required'
                ]);

            }



            $top_recruiters = array();
            $famous_imgage = array();
            $careerjobs = array();
            $query = Career::whereId($id)->first();
            $query->name = $request->name;
            $query->about = $request->about;
            $query->slug = $request->slug;
            $query->type = $request->career_type;
            $query->banner_title = $request->banner_title;
             if (isset($_FILES['career_icon']['name']) && $_FILES['career_icon']['name'] != ''):
                $careericon = $request->file('career_icon');
                $imgname = time() . '.' . $careericon->getClientOriginalExtension();
                \Storage::disk('s3')->delete('/career/career-icon/' . $query->career_icon);
                $s3 = \Storage::disk('s3');
                $filePath = '/career/career-icon/' . $imgname;
                $s3->put($filePath, file_get_contents($careericon), 'public');
                $career_icon = $imgname; 
            else:
                $career_icon = $query->career_icon;
            endif;
             $query->career_icon = $career_icon;
             if (isset($_FILES['career_banner']['name']) && $_FILES['career_banner']['name'] != ''):
                $careerbanner = $request->file('career_banner');
                $imgname = time() . '.' . $careerbanner->getClientOriginalExtension();
                \Storage::disk('s3')->delete('/career/career-banner/' . $query->career_banner);
                $s3 = \Storage::disk('s3');
                $filePath = '/career/career-banner/' . $imgname;
                $s3->put($filePath, file_get_contents($careerbanner), 'public');
                $career_banner = $imgname;                                
            else:
                $career_banner = $query->career_banner;
            endif;
            $query->career_banner = $career_banner;
            if (isset($_FILES['career_banner']['name']) && $_FILES['career_banner']['name'] != ''):
                $careerthumb = $request->file('career_banner');
                $expertimageFileName = time() . '.' . $careerthumb->getClientOriginalExtension();                
                $s3 = \Storage::disk('s3');
                $filePath = '/career/career-thumb/' . $expertimageFileName;
                $destinationPath = public_path('/thumbnail_images');
                 $thumb_img = Image::make($careerthumb->getRealPath());
                 $thumb_img->resize(300, null, function ($constraint) {
                 $constraint->aspectRatio();
                });
                $thumb_img->save($destinationPath.'/'.$expertimageFileName);

                $s3->put($filePath, file_get_contents($destinationPath.'/'.$expertimageFileName), 'public');
                unlink($destinationPath.'/'.$expertimageFileName);
                $career_thumb = $expertimageFileName;                              
            else:
                $career_thumb = $query->career_banner;
            endif;
             $query->career_thumb = $career_thumb;
             if($request->career_type==1){
               if (isset($_FILES['exp_video']['name']) && $_FILES['exp_video']['name'] != ''):
                $expvideo = $request->file('exp_video');
                $expvideoname = time() . '.' . $expvideo->getClientOriginalExtension();
                \Storage::disk('s3')->delete('/career/career-video/' . $query->exp_video);
                $s3 = \Storage::disk('s3');
                $filePath = '/career/career-video/' . $expvideoname;
                $s3->put($filePath, file_get_contents($expvideo), 'public');
                $exp_video = $expvideoname;                                
            else:
                $exp_video = $query->exp_video;
            endif;
             if (isset($_FILES['video_thumb']['name']) && $_FILES['video_thumb']['name'] != ''):
                $video_thumb= $request->file('video_thumb');
                $expthumbname = time() . '.' . $video_thumb->getClientOriginalExtension();
                 \Storage::disk('s3')->delete('/career/career-video/' . $query->video_thumb);
                $s3 = \Storage::disk('s3');
                $filePath = '/career/career-video/' . $expthumbname;
                $s3->put($filePath, file_get_contents($video_thumb), 'public');
                $exp_thumb_name = $expthumbname;                                
            else:
                $exp_thumb_name = $query->video_thumb;
            endif;
             $query->exp_video = $exp_video;   
             $query->video_thumb = $exp_thumb_name;
             $query->video_title = $request->video_title;
             $query->video_designation = $request->video_designation;
             $query->tte_career_id = $request->tte_career_id;
              foreach ($request->title_do as $key => $value) :
                 
                      $do_you_know[] = array('title' => $value, 'description' => $request->desc_do[$key]);
                            
            endforeach;
            $query->do_you_know = json_encode($do_you_know);
             }
             if($request->career_type==2){
            $query->parent = isset($request->parent_id)?$request->parent_id:0;
            $query->area_cover = json_encode($request->area_covers);
            $query->career_ladder = json_encode($request->career_ladders);
//            $query->undergraduate_eligibility_criteria = $request->undergraduate_eligibility_criteria;
//            $query->postgraduate_eligibility_criteria = $request->postgraduate_eligibility_criteria;
             $query->pros = $request->pros;
            $query->cons = $request->cons;
            // Save related career
            foreach ($request->related_title as $key => $value) :
               
                $related_career[] = array('title' => $value, 'description' => $request->related_desc[$key]);
            endforeach;

            $query->related_career = json_encode($related_career);
            //save competencies
             foreach ($request->competencies_title as $key => $value) :
               
                $competencies[] = array('title' => $value, 'description' => $request->competencies_desc[$key]);
            endforeach;

            $query->competencies = json_encode($competencies);
            foreach ($request->job_title as $key => $value) :
               
                $careerjobs[] = array('title' => $value, 'description' => $request->job_desc[$key]);
            endforeach;

            $query->career_jobs = json_encode($careerjobs);
//            $query->expected_remuneration = json_encode(array($request->beginner, $request->intermediate, $request->expertt));
//            $query->traits_in_pointers = json_encode($request->traits_pointer);

//            // Save famous Personalities
//            foreach ($request->designation as $key => $value) :
//                if (isset($_FILES['famous_img']['name'][$key]) && $_FILES['famous_img']['name'][$key] != ''):
//                    $imgname = time() . '_' . $_FILES['famous_img']['name'][$key];
//                    $destinationPath = public_path('/image/famous_img/') . $imgname;
//                    move_uploaded_file($_FILES['famous_img']['tmp_name'][$key], $destinationPath);
//                    $img = $imgname;
//                else:
//                    $img = '';
//                endif;
//                $famous_image[] = array('designation' => $value, 'famous_img' => $img);
//            endforeach;
//
//            $query->famouse_personaliities = json_encode($famous_image);

            //print_r($famous_image);die();
            //save graph and text
//            if (isset($_FILES['graph']['name']) && $_FILES['graph']['name'] != ''):
//                $imgname = time() . '_' . $_FILES['graph']['name'];
//                $destinationPath = public_path('/image/graph/') . $imgname;
//                move_uploaded_file($_FILES['graph']['tmp_name'], $destinationPath);
//                $img = $imgname;
//            else:
//                $img = '';
//            endif;            
//            $query->lies_ahead = json_encode(array('text' => $request->text, 'graph' => $img));  
            $query->prospect = $request->prospect;
            $query->salary = $request->salary;
            $query->key_psychology = $request->key_psychology;
            
//            $query->top_colleges = json_encode($request->top_college);
           }
            $query->save();
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
    public function destroy($type,$id) {
        try {
            $career = Career::find($id);
            \Storage::disk('s3')->delete('/career/career-icon/' . $career->career_icon);
            \Storage::disk('s3')->delete('/career/career-banner/' . $career->career_banner);
            if($type==1){
            \Storage::disk('s3')->delete('/career/career-video/' . $career->exp_video);
            Career::whereParent($id)->delete();
            }
            CareerScholarship::whereCareerId($id)->delete();
            CareerExam::whereCareerId($id)->delete();
            Career::find($id)->delete();
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return $e->getErrors();
        }
        return back()->with('success', 'Deleted Successfully !!');
    }

    /**
     * Update the specified status resource in  database storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request) {
        $id = $request->id;
        $val = $request->status;
        try {
            $model = Career::find($id);
            $model->status = $val;
            $model->save();
            return response()->json($id);
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return $e->getErrors();
        }
    }

    /*
     * Add career Entrance Examination
     *   
     */

    public function addExam($subcareer_id) {
       
        $careerlist = Helper::getCareer();
        $examfor = array(
            "Undergraduate" => "Undergraduate",
            "Post Graduate" => "Post Graduate"
        );
        return view('admin.career_library.examadd', compact('careerlist', 'examfor','subcareer_id'));
    }

    /*

     * Save exam
     *  
     */

    public function saveExam(Request $request) {
        try {

            $this->validate($request, [
//                'name' => 'required',
//                'about' => 'required',
            ]);

            if (isset($request->name)):
                $data = array();
                foreach ($request->name as $key => $value) :
                    //if ($value != ''):
                    $proimg = '';
                    if (isset($_FILES['logo']['name'][$key]) && $_FILES['logo']['name'][$key] != ''):
                        $proimgname = time() . '_' . $_FILES['logo']['name'][$key];
                        $proPath = public_path('/image/career_exam/logo/') . $proimgname;
                        move_uploaded_file($_FILES['logo']['tmp_name'][$key], $proPath);
                        $proimg = $proimgname;
                    endif;
                    $appli = '';
                    if (isset($_FILES['application_form']['name'][$key]) && $_FILES['application_form']['name'][$key] != ''):
                        $appliname = time() . '_' . $_FILES['application_form']['name'][$key];
                        $appliPath = public_path('/image/career_exam/document/') . $appliname;
                        move_uploaded_file($_FILES['application_form']['tmp_name'][$key], $appliPath);
                        $appli = $appliname;
                    endif;
                     $syllabus = '';
                    if (isset($_FILES['syllabus']['name'][$key]) && $_FILES['syllabus']['name'][$key] != ''):
                        $syllabusname = time() . '_' . $_FILES['syllabus']['name'][$key];
                        $syllabusPath = public_path('/image/career_exam/syllabus/') . $syllabusname;
                        move_uploaded_file($_FILES['syllabus']['tmp_name'][$key], $syllabusPath);
                        $syllabus = $syllabusname;
                    endif;
                    $data[] = array(
                        'career_id' => $request->career_id,
                        'name' => $value,
                        'details' => $request->details[$key],
                        'logo' => $proimg,
                        'application_form' => $appli,
                        'syllabus' => $syllabus,
                        'exam_date' => $request->date_of_exam[$key],
                        'application_fee' => $request->application_fee[$key],
                        'exam_for' => $request->exam_for[$key],
//                            'created_by' => Auth::user()->id,
                        'created_at' => date('Y-m-d h:i:s'),
                    );
                    //endif;
                endforeach;
                CareerExam::insert($data);
            endif;
            return back()->with('success', 'Successfully Added !!');
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    /*
     * show exam
     * 
     */

    public function showExam($subcareer_id,$id) {
       
        $careerlist = Helper::getCareer();
        $examfor = array(
            "Undergraduate" => "Undergraduate",
            "Post Graduate" => "Post Graduate"
        );
        $career_id = $id;
        $careerexam = CareerExam::where('career_id', $id)->get();
        $careername = Career::select('name')->whereId($id)->first();
        return view('admin.career_library.examedit', compact('careerlist', 'careername', 'examfor', 'careerexam', 'career_id','subcareer_id'));
    }

    /*

     * Update Exam
     * 
     *  */

    public function editExam(Request $request) {
        try {

            $this->validate($request, [
//                'name' => 'required',
//                'about' => 'required',
            ]);

            if (isset($request->name)):
                $data = array();
                foreach ($request->name as $key => $value) :
                    //if ($value != ''):
                    $proimg = '';
                    if (isset($_FILES['logo']['name'][$key]) && $_FILES['logo']['name'][$key] != ''):
                        $proimgname = time() . '_' . $_FILES['logo']['name'][$key];
                        $proPath = public_path('/image/career_exam/logo/') . $proimgname;
                        move_uploaded_file($_FILES['logo']['tmp_name'][$key], $proPath);
                        $proimg = $proimgname;
                    else:
                        $proimg = $request->examlogo[$key];
                    endif;
                    $appli = '';
                    if (isset($_FILES['application_form']['name'][$key]) && $_FILES['application_form']['name'][$key] != ''):
                        $appliname = time() . '_' . $_FILES['application_form']['name'][$key];
                        $appliPath = public_path('/image/career_exam/document/') . $appliname;
                        move_uploaded_file($_FILES['application_form']['tmp_name'][$key], $appliPath);
                        $appli = $appliname;
                    else:
                        $appli = $request->applidoc[$key];
                    endif;
                     $syllabus = '';
                    if (isset($_FILES['syllabus']['name'][$key]) && $_FILES['syllabus']['name'][$key] != ''):
                        $syllabusname = time() . '_' . $_FILES['syllabus']['name'][$key];
                        $syllabusPath = public_path('/image/career_exam/syllabus/') . $syllabusname;
                        move_uploaded_file($_FILES['syllabus']['tmp_name'][$key], $syllabusPath);
                        $syllabus = $syllabusname;
                        else:
                        $appli = $request->syllb[$key];
                    endif;
                    $data[] = array(
                        'career_id' => $request->career_id,
                        'name' => $value,
                        'details' => $request->details[$key],
                        'logo' => $proimg,
                        'application_form' => $appli,
                        'syllabus' => $syllabus,
                        'exam_date' => $request->date_of_exam[$key],
                        'application_fee' => $request->application_fee[$key],
                        'exam_for' => $request->exam_for[$key],
                        'created_at' => date('Y-m-d h:i:s'),
                    );
                    //endif;
                endforeach;
                if (CareerExam::where('career_id', $request->career_id)->delete()):
                    CareerExam::insert($data);
                    return back()->with('success', 'Updated Successfully !!');
                else:
                    return back()->with('success', 'An error occur while updating the data !!');
                endif;

            endif;
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    /*

     * Add Career Scholarship
     * 
     */

    public function addScholarship($subcareer_id) {
       
        $careerlist = Helper::getCareer();
        return view('admin.career_library.scholarship', compact('careerlist','subcareer_id'));
    }
    
    /*

     * Save Career Scholarship
     * 
     */
    public function saveScholarship(Request $request) {
        try {
            $this->validate($request, [
                'career_id' => 'required',
            ]);

            $datalist = array();
            CareerScholarship::where('career_id', $request->college_id)->delete();
            if ($request->scoller_offer != ''):
                foreach ($request->scoller_offer as $key => $value) :
                    if ($value != ''):
                        $appli = '';
                        if (isset($_FILES['download_appli']['name'][$key]) && $_FILES['download_appli']['name'][$key] != ''):
                            $appliname = time() . '_' . $_FILES['download_appli']['name'][$key];
                            $destinationPath = public_path('/careerScholarshipAppli/') . $appliname;
                            move_uploaded_file($_FILES['download_appli']['tmp_name'][$key], $destinationPath);
                            $appli = $appliname;
                        else:
                            $appli = $request->applidoc[$key];
                        endif;
                        $datalist[] = array(
                            'career_id' => $request->career_id,
                            'scholarships_offered' => $value,
                            'eligibility_criteria' => $request->eligibility_criteria[$key],
                            'process_details' => $request->appli_process[$key],
                            'last_date_of_application' => date('Y-m-d', strtotime($request->last_date_to_appli[$key])),
                            'download' => $appli,
                            'created_at' => date('Y-m-d h:i:s'),
                        );
                    endif;

                    // $query->career_ladder                       = $img;
                    // $query->pros                                = $request->pros;
                    // $query->cons                                = $request->cons;
                    // $query->top_colleges                        = json_encode($request->top_college);
                    // $query->save();
                    //return back()->with('success', 'Record Successfully Update !!');
                endforeach;
                CareerScholarship::insert($datalist);

            endif;
            return back()->with('success', 'Successfully Saved !!');

            /* Insert your data */
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }
    /*

     * show Career Scholarship
     * 
     */
    public function showScholarship($subcareer_id,$id) {
     
        $career_id = $id;
        $scholarship = CareerScholarship::where('career_id', $id)->get();
        $careername = Career::select('name')->whereId($id)->first();
        return view('admin.career_library.editscholarship', compact('careername', 'scholarship', 'career_id','subcareer_id'));
    }

    /*

     * show Career Video
     * @param id
     */

    public function showCareerVideo($id,$subcareer_id) {
        $career_id = $id;
        $careervideo = CareerLibaryVideo::where('career_id', $id)->get();
        $careername = Career::select('name')->whereId($id)->first()->name;
        return view('admin.career_library.videolist', compact('careername', 'careervideo', 'career_id','subcareer_id'));
    }

    /*
     * Add Career Video
     */

    public function addCareerVideo($subcareer_id) {
        $careerlist = Helper::getCareer();
        $videotype = array(
            "1" => "Expert",
            "2" => "Intermediate",
            "3" => "beginner"
        );
        return view('admin.career_library.addvideo', compact('careerlist', 'videotype','subcareer_id'));
    }
    
    /*

     * Save Career Video
     * 
     */

    public function saveCareerVideo(Request $request) {
        ini_set('memory_limit', '-1');
        try {
            // $uniqueRule =  Rule::unique('gpts_career_library_video')->where(function ($query) use 
            // ($data){
            //     return $query->where('career_id', 1)->where('type', 1);
            // });
           // print_r($uniqueRule->all());
           $validator = Validator::make($request->all(), [
                'career_id' => 'required',
                'type' => 'required',
                'title' => 'required',
               'designation' => 'required',
                'video' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm',
            ]);



            //$checkVideoExisting = CareerLibaryVideo::where('career_id', $request->career_id)
                                //->where('type', $request->type)->count();
           
            //if ($validator->fails() || $checkVideoExisting > 0) {
            if ($validator->fails()) {
                $errorAll	=  array();
                if($validator->fails()){
                    foreach($validator->errors()->getMessages() as $key => $error ){
                        array_push($errorAll, $error[0]);
                    }
                }else{
                        array_push($errorAll, 'Video already exist.');
                }
                return back()->with('error', $errorAll)
                            ->with('oldname', $request->name)
                            ->with('oldtitle', $request->title)
                            ->with('oldtype', $request->type)
                            ->with('oldcareer', $request->career_id);
            }else{

                $query = new CareerLibaryVideo();
                $query->career_id = $request->career_id;
                $query->title = $request->title;
                $query->type = $request->type;
                $query->name = $request->name;
                $query->about = $request->about;
                if(Auth::user()->usertype==11 || Auth::user()->usertype==12):
                    $query->status = 1;
                else:
                    $query->status=0;
                endif;
                $query->designation = $request->designation;
                $video = '';
                $thumb = '';
             if($request->type==1):
            if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''):
                $expert_video = $request->file('video');
                $expertimageFileName = time() . '.' . $expert_video->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = '/career-library/Expert/' . $expertimageFileName;
                $s3->put($filePath, file_get_contents($expert_video), 'public');
                $video = $expertimageFileName;
            endif;
             if (isset($_FILES['video_thumb']['name']) && $_FILES['video_thumb']['name'] != ''):
                $expert_thumb = $request->file('video_thumb');
                $expertimageFileName = time() . '.' . $expert_thumb->getClientOriginalExtension();                
                $s3 = \Storage::disk('s3');
                $filePath = '/career-library/Expert/' . $expertimageFileName;
                $destinationPath = public_path('/thumbnail_images');
                 $thumb_img = Image::make($expert_thumb->getRealPath());
                 $thumb_img->resize(1024, null, function ($constraint) {
                 $constraint->aspectRatio();
                });
                $thumb_img->save($destinationPath.'/'.$expertimageFileName);

                $s3->put($filePath, file_get_contents($destinationPath.'/'.$expertimageFileName), 'public');
                unlink($destinationPath.'/'.$expertimageFileName);
                $thumb = $expertimageFileName;
            endif;
            endif;
            if($request->type==2):
            if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''):
                $intermediate_video = $request->file('video');
                $intermediateimageFileName = time() . '.' . $intermediate_video->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = '/career-library/Intermediate/' . $intermediateimageFileName;
                $s3->put($filePath, file_get_contents($intermediate_video), 'public');
                $video = $intermediateimageFileName;
            endif;
              if (isset($_FILES['video_thumb']['name']) && $_FILES['video_thumb']['name'] != ''):
                $intermediate_thumb = $request->file('video_thumb');
                $expertimageFileName = time() . '.' . $intermediate_thumb->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = '/career-library/Intermediate/' . $expertimageFileName;
                $destinationPath = public_path('/thumbnail_images');
                 $thumb_img = Image::make($intermediate_thumb->getRealPath());
                 $thumb_img->resize(1024, null, function ($constraint) {
                 $constraint->aspectRatio();
                });
                $thumb_img->save($destinationPath.'/'.$expertimageFileName);

                $s3->put($filePath, file_get_contents($destinationPath.'/'.$expertimageFileName), 'public');
                unlink($destinationPath.'/'.$expertimageFileName);
                $thumb = $expertimageFileName;
            endif;
            endif;
            if($request->type==3):
            if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''):
                $beginner_video = $request->file('video');
                $beginnerimageFileName = time() . '.' . $beginner_video->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = '/career-library/Beginner/' . $beginnerimageFileName;
                $s3->put($filePath, file_get_contents($beginner_video), 'public');
                $video = $beginnerimageFileName;
            endif;
              if (isset($_FILES['video_thumb']['name']) && $_FILES['video_thumb']['name'] != ''):
                $beginner_thumb = $request->file('video_thumb');
                $expertimageFileName = time() . '.' . $beginner_thumb->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = '/career-library/Beginner/' . $expertimageFileName;
                $destinationPath = public_path('/thumbnail_images');
                 $thumb_img = Image::make($beginner_thumb->getRealPath());
                  $thumb_img->resize(1024, null, function ($constraint) {
                 $constraint->aspectRatio();
                });
                $thumb_img->save($destinationPath.'/'.$expertimageFileName);

                $s3->put($filePath, file_get_contents($destinationPath.'/'.$expertimageFileName), 'public');
                unlink($destinationPath.'/'.$expertimageFileName);
                $thumb = $expertimageFileName;
            endif;
            endif;
            $query->video = $video;
            $query->video_thumb = $thumb;
            $query->save();
            return back()->with('success', 'Successfully Added !!');
            }
            // $this->validate($request, [
            //     'career_id' => 'required',
            //     'type' => 'required',
            //     'video' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm',
            // ]);
           
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }
    
    /*

     * Edit Career Video
     * 
     */
    public function editCareerVideo($career_id,$id,$subcareer_id) {
        $careervideo = CareerLibaryVideo::find($id);
        $careervideo['videotype'] = Helper::getVideoType($careervideo->type);
        
        return view('admin.career_library.editvideo', compact('careervideo','career_id','subcareer_id'));
    }

    /*
        Upload career video
    */
    public function updateCareerVideo(Request $request,$id) {
        ini_set('memory_limit', '-1');
        try {
            $this->validate($request, [
                'career_id' => 'required',
                'type' => 'required',
            ]);
          $query = CareerLibaryVideo::find($id);
           $video = '';
           $thumb = '';
            if($request->type==1):
            if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''):
                $expert_video = $request->file('video');
                $expertimageFileName = time() . '.' . $expert_video->getClientOriginalExtension();
                \Storage::disk('s3')->delete('/career-library/Expert/' . $query->video);
                $s3 = \Storage::disk('s3');
                $filePath = '/career-library/Expert/' . $expertimageFileName;
                $s3->put($filePath, file_get_contents($expert_video), 'public');
                $video = $expertimageFileName;
            else:
                $video = $query->video;
           
            endif;
            if (isset($_FILES['video_thumb']['name']) && $_FILES['video_thumb']['name'] != ''):
                $expert_video_thumb = $request->file('video_thumb');
                $expertimageFileName = time() . '.' . $expert_video_thumb->getClientOriginalExtension();
                \Storage::disk('s3')->delete('/career-library/Expert/' . $query->video_thumb);
                $s3 = \Storage::disk('s3');
                $filePath = '/career-library/Expert/' . $expertimageFileName;
               $destinationPath = public_path('/thumbnail_images');
                 $thumb_img = Image::make($expert_video_thumb->getRealPath());
                $thumb_img->resize(1024, null, function ($constraint) {
                 $constraint->aspectRatio();
                });
                $thumb_img->save($destinationPath.'/'.$expertimageFileName);

                $s3->put($filePath, file_get_contents($destinationPath.'/'.$expertimageFileName), 'public');
                unlink($destinationPath.'/'.$expertimageFileName);
                $thumb = $expertimageFileName;
            else:
                $thumb = $query->video_thumb;
           
            endif;
            endif;
            if($request->type==2):
            if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''):
                $intermediate_video = $request->file('video');
                $intermediateimageFileName = time() . '.' . $intermediate_video->getClientOriginalExtension();
                \Storage::disk('s3')->delete('/career-library/Intermediate/' . $query->video);
                $s3 = \Storage::disk('s3');
                $filePath = '/career-library/Intermediate/' . $intermediateimageFileName;
                $s3->put($filePath, file_get_contents($intermediate_video), 'public');
                $video = $intermediateimageFileName;
            else:
                $video = $query->video;
            endif;   
              if (isset($_FILES['video_thumb']['name']) && $_FILES['video_thumb']['name'] != ''):
                $intermediate_video_thumb = $request->file('video_thumb');
                $expertimageFileName = time() . '.' . $intermediate_video_thumb->getClientOriginalExtension();
                \Storage::disk('s3')->delete('/career-library/Intermediate/' . $query->video_thumb);
                $s3 = \Storage::disk('s3');
                $filePath = '/career-library/Intermediate/' . $expertimageFileName;
                $destinationPath = public_path('/thumbnail_images');
                 $thumb_img = Image::make($intermediate_video_thumb->getRealPath());
                  $thumb_img->resize(1024, null, function ($constraint) {
                 $constraint->aspectRatio();
                });
               
                $thumb_img->save($destinationPath.'/'.$expertimageFileName);

                $s3->put($filePath, file_get_contents($destinationPath.'/'.$expertimageFileName), 'public');
                unlink($destinationPath.'/'.$expertimageFileName);
                $thumb = $expertimageFileName;
            else:
                $thumb = $query->video_thumb;
           
            endif;
            endif;
            if($request->type==3):
            if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''):
                $beginner_video = $request->file('video');
                $beginnerimageFileName = time() . '.' . $beginner_video->getClientOriginalExtension();
                \Storage::disk('s3')->delete('/career-library/Beginner/' . $query->video);
                $s3 = \Storage::disk('s3');
                $filePath = '/career-library/Beginner/' . $beginnerimageFileName;
                $s3->put($filePath, file_get_contents($beginner_video), 'public');
                $video = $beginnerimageFileName;
            else:
                $video = $query->video;
            endif;
             if (isset($_FILES['video_thumb']['name']) && $_FILES['video_thumb']['name'] != ''):
                $beginner_video_thumb = $request->file('video_thumb');
                $expertimageFileName = time() . '.' . $beginner_video_thumb->getClientOriginalExtension();
                \Storage::disk('s3')->delete('/career-library/Beginner/' . $query->video_thumb);
                $s3 = \Storage::disk('s3');
                $filePath = '/career-library/Beginner/' . $expertimageFileName;
                $destinationPath = public_path('/thumbnail_images');
                 $thumb_img = Image::make($beginner_video_thumb->getRealPath());
                 $thumb_img->resize(1024, null, function ($constraint) {
                 $constraint->aspectRatio();
                });
                $thumb_img->save($destinationPath.'/'.$expertimageFileName);

                $s3->put($filePath, file_get_contents($destinationPath.'/'.$expertimageFileName), 'public');
                unlink($destinationPath.'/'.$expertimageFileName);
                $thumb = $expertimageFileName;
            else:
                $thumb = $query->video_thumb;
           
            endif;
            endif;
            $query->title = $request->title;
            $query->name = $request->name;
            $query->video_thumb = $thumb;
             $query->video = $video;
             $query->about = $request->about;
             $query->designation = $request->designation;
            $query->save();
            return back()->with('success', 'Successfully Updated !!');
             } catch (\Laracasts\Validation\FormValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
     
    }

    /*
        Delete college carrer video
    */
    public function deleteCareerVideo($type,$video,$thumb, $id) {
        try {
            if($type==1){
            \Storage::disk('s3')->delete('/career-library/Expert/' . $video);
            \Storage::disk('s3')->delete('/career-library/Expert/' . $thumb);
            }else if($type==2){
            \Storage::disk('s3')->delete('/career-library/Intermediate/' . $video);
            \Storage::disk('s3')->delete('/career-library/Intermediate/' . $thumb);
            }else if($type==3){
            \Storage::disk('s3')->delete('/career-library/Beginner/' . $video);
            \Storage::disk('s3')->delete('/career-library/Beginner/' . $thumb);
            }
            CareerLibaryVideo::whereId($id)->delete();
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return $e->getErrors();
        }
        return back()->with('success', 'Deleted Successfully !!');
    }
    public function changesvideostatus($post_id, $status) {
        $post = CareerLibaryVideo::
                where('id', $post_id)
                ->update(['status' => $status]);
        echo json_encode(array("succ" => "Status Updated Successfully"));
    }

    /* Destroy Image From AWS server */
    // public function destroy($image)
    //    {
    //        Storage::disk('s3')->delete('images/' . $image);
    //        return back()->withSuccess('Image was deleted successfully');
    //    }
//'https://s3.eu-west-1.amazonaws.com/gpts-portal/';
}
