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
use App\CollegeFacilities;
use App\CollegeAlumni;
use App\CollegeGallery;
use App\CollegeScolarship;
use App\CollegeWhyChoose;
use App\CollegeCourse;
use App\NanoClass;
use App\TTECareer;
use Auth;
use Hash;
use Mail;
use Config;
use App\EmailTemplate;
use View;
use Illuminate\Support\Facades\Route;

class CollageDashboardController extends Controller {

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
    public function index(Request $request) {


        $currentPath = Route::getFacadeRoot()->current()->uri();
        $explodePath = explode('/', $currentPath);
        if (!in_array($explodePath[1], $this->userPermission)) {
            return view('admin.not-allow');
        }
        $searchKey = (isset($request->all()['Search'])) ? $request->all()['Search'] : '';
        $query = College::select('gpts_college.*','user.status', 'user.name as collegename', 'user.email', 'user.contact')->LeftJoin('users as user', 'user.id', '=', 'gpts_college.user_id');
        $query->whereIn('user.usertype', [2]);
        $query->where('user.status','!=', 0);
        // if (Auth::user()->usertype != 11) {
        // $query->whereCreatedBy(Auth::user()->id);
        // }
        $query->where('user.name', 'LIKE', '%' . $searchKey . '%');
        $query->orderBy('user.name', 'Desc');
        $user = $query->paginate(20);
        foreach ($user as $key => $value) :
            $value['total_gallery'] = CollegeGallery::where('college_id', $value['user_id'])->groupBy('college_id')->count();
            $value['total_scholarship'] = CollegeScolarship::where('college_id', $value['user_id'])->groupBy('college_id')->count();
            $value['total_course'] = CollegeCourse::where('college_id', $value['user_id'])->groupBy('college_id')->count();
            $value['total_nano_classes'] = NanoClass::where('college_id', $value['user_id'])->groupBy('college_id')->count();
            $user[$key] = $value;
        endforeach;



        return view('admin.collage.index', compact('user'));
    }

    /**
     * Display the collage list.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unilist(Request $request) {

        $currentPath = Route::getFacadeRoot()->current()->uri();
        $explodePath = explode('/', $currentPath);
        if (!in_array($explodePath[1], $this->userPermission)) {
            return view('admin.not-allow');
        }
        $searchKey = (isset($request->all()['Search'])) ? $request->all()['Search'] : '';
        $query = College::select('gpts_college.*', 'user.status','user.name as collegename', 'user.email', 'user.contact')->LeftJoin('users as user', 'user.id', '=', 'gpts_college.user_id');
        $query->whereIn('user.usertype', [3]);
//        $query->where('user.status', 1);
        // if (Auth::user()->usertype != 11) {
        // $query->whereCreatedBy(Auth::user()->id);
        // }
        $query->where('user.name', 'LIKE', '%' . $searchKey . '%');
        $query->orderBy('user.name', 'Desc');
        $user = $query->paginate(20);
        foreach ($user as $key => $value) :
            $value['total_gallery'] = CollegeGallery::where('college_id', $value['user_id'])->groupBy('college_id')->count();
            $value['total_scholarship'] = CollegeScolarship::where('college_id', $value['user_id'])->groupBy('college_id')->count();
            $user[$key] = $value;
        endforeach;

        return view('admin.collage.unilist', compact('user'));
    }

    /*

     * Add Collage Basic info
     *   
     */

    public function addUniversity() {

        $currentPath = Route::getFacadeRoot()->current()->uri();
        $explodePath = explode('/', $currentPath);
        if (!in_array($explodePath[1], $this->userPermission)) {
            return view('admin.not-allow');
        }
        $collageType = Helper::getCollageType();



        return view('admin.collage.adduni', compact('collageType'));
    }

    /*

     * Add Collage Basic info
     *   
     */

    public function add() {
        //echo 'dsds';die();
        $currentPath = Route::getFacadeRoot()->current()->uri();
        $explodePath = explode('/', $currentPath);
        if (!in_array($explodePath[1], $this->userPermission)) {
            return view('admin.not-allow');
        }
        $collageType = Helper::getCollageType();
        $universityType = Helper::getUniversity();
        $facIcons = Helper::getfacultyicons();

        $tte_careers=TTECareer::all();

        return view('admin.collage.add', compact('collageType', 'universityType','facIcons','tte_careers'));
    }

    /*

     * Save collage
     * @return \Illuminate\Http\Response
     *   
     */

    public function save(Request $request) {
        // foreach ($request->alumni_desc as $key => $value){
        // echo $_FILES['alumni_pic']['name'][$key];
        // }
        // die();
        ini_set('memory_limit', '-1');

        try {

            $this->validate($request, [
                'name' => 'required',
                'website' => 'required',
                'email' => 'required|unique:users|email',
                'slug' => 'required|unique:gpts_college,slug',
                'mobile_no' => 'numeric|min:10',
                'address' => 'required'
            ]);


            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->contact = $request->mobile_no;
            $password = str_random(8);
            $user->password = Hash::make($password);
            $user->created_by = Auth::user()->id;
            $user->usertype = $request->usertype;
            $user->created_at = date('Y-m-d h:i:s');
            $user->save();
            $userId = $user->id;
            $alumni = array();
            if ($userId) {

                // Save video and thumb
                if (isset($_FILES['video_thumb']['name']) && $_FILES['video_thumb']['name'] != ''):
                    $thumb     = $request->file('video_thumb');
                    $imgname        = $request->college.'-'.time() . '.' . $thumb->getClientOriginalExtension();
                    $s3             = \Storage::disk('s3');
                    $filePath       = '/college-video/thumb/' . $imgname;
                    $s3->put($filePath, file_get_contents($thumb), 'public');
                    $video_thumb    = $imgname; 
                else:
                    $video_thumb    = '';
                endif;
    
                if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''):
                    $edvideo        = $request->file('video');
                    $videoname      = $request->college.'-'.time() . '.' . $edvideo->getClientOriginalExtension();
                    $s3             = \Storage::disk('s3');
                    $filePath       = '/college-video/video/' . $videoname;
                    $s3->put($filePath, file_get_contents($edvideo), 'public');
                    $video          = $videoname;                                
                else:
                    $video          = '';
                endif;
                
                if($request->tte_career){
                    $tte_career=implode(',',$request->tte_career);
                }else{
                    $tte_career='';
                }
                
                // Save data to college table
                $college = new College;
                $college->user_id = $userId;
                $college->collage_type = $request->collage_type;
                $college->slug = $request->slug;
                $college->university_affiliated = $request->university_type;
                $college->tte_career=$tte_career;
                $college->user_name = $request->name;
                $college->about = $request->about;
                $college->phone_no = $request->mobile_no;
                $college->landline_no = $request->landline_no;
                $college->alternative_no = $request->alternative_no;
                $college->average_package_offer = $request->average_package_offer;
                $college->address   = $request->address;
                $college->website   = $request->website;
                $college->video     = $video;
                $college->thumb     = $video_thumb;
            
                if ($request->hasFile('logo')) {
                    $image = $request->file('logo');
                    $name = time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/image/logo/');
                    $image->move($destinationPath, $name);
                    $college->logo = $name;
                }
                if ($request->hasFile('cover_img')) {
                    $image = $request->file('cover_img');
                    $covername = time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/image/coverimg/');
                    $image->move($destinationPath, $covername);
                    $college->cover_logo = $covername;
                }
                if ($request->hasFile('head_inst_img')) {
                    $image = $request->file('head_inst_img');
                    $headname = time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/image/head_inst_img/');
                    $image->move($destinationPath, $headname);
                    $college->head_inst_img = $headname;
                }
                $college->head_inst_msg = $request->head_inst_msg;
                $college->infrastructure = $request->infrastructure;
                $college->life_on_capm = $request->life_on_capm;
                $college->learn_exp = $request->learn_exp;
                $college->extra_curr = $request->extra_curr;
                $college->happi_quot = $request->happi_quot;
                $college->alumni_value = $request->alumni_value;
                if ($request->hasFile('ssi_report')) {
                    $image = $request->file('ssi_report');
                    $ssi_reportname = time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/satisfaction-report');
                    $image->move($destinationPath, $ssi_reportname);
                    $college->ssi_report = $ssi_reportname;
                }
                $college->created_at = date('Y-m-d h:i:s');
                $college->save();
                $collegeId = $college->id;
                if ($collegeId) {

                      if (isset($request->compy_name)):
                    $Prominent = array();
                    foreach ($request->compy_name as $key => $value) :
                        //if ($value != ''):
                        $proimg = '';
                        if (isset($_FILES['pro_logo']['name'][$key]) && $_FILES['pro_logo']['name'][$key] != ''):
                            $proimgname = time() . '_' . $_FILES['pro_logo']['name'][$key];
                            $proPath = public_path('/image/recruiters_image/') . $proimgname;
                            move_uploaded_file($_FILES['pro_logo']['tmp_name'][$key], $proPath);
                            $proimg = $proimgname;
                        endif;
                        $Prominent[] = array(
                            'college_id' => $userId,
                            'compy_name' => $value,
                            'av_salary' => $request->av_salary[$key],
                            'logo' => $proimg,
                            'created_by' => Auth::user()->id,
                            'created_at' => date('Y-m-d h:i:s'),
                        );
                        //endif;
                    endforeach;
                    CollegeProminent::insert($Prominent);
                    endif;
                    //Save facelities
                    if (isset($request->icon)):
                    $fac = array();
                    foreach ($request->icon as $key => $value) :
                        //if ($value != ''):
                        $fac[] = array(
                            'college_id' => $userId,
                            'icon' => $value,
                            'created_by' => Auth::user()->id,
                            'created_at' => date('Y-m-d h:i:s'),
                        );
                        //endif;
                    endforeach;
                    CollegeFacilities::insert($fac);
                    endif;
                    //Save Why Choose Us
                    if(isset($request->choose_title)):
                    $choose = array();
                    foreach ($request->choose_title as $key => $value) :
                        //if ($value != ''):
                        $choose[] = array(
                            'college_id' => $userId,
                            'text' => $value,
                            'descr' => $request->choose_desc[$key],
                            'created_at' => date('Y-m-d h:i:s'),
                        );
                  
                    endforeach;
                    CollegeWhyChoose::insert($choose);
                   endif;
                    // Save alumni
                    if (isset($request->alumni_desc)):
                    foreach ($request->alumni_desc as $key => $value) :

                        //if ($value != ''):
                        $alumniimg = '';
                        if (isset($_FILES['alumni_pic']['name'][$key]) && $_FILES['alumni_pic']['name'][$key] != ''):
                            $alumniimgname = time() . '_' . $_FILES['alumni_pic']['name'][$key];
                            $destinationPath = public_path('/image/alumni_pic/') . $alumniimgname;
                            move_uploaded_file($_FILES['alumni_pic']['tmp_name'][$key], $destinationPath);
                            $alumniimg = $alumniimgname;
                        endif;
                        $alumni[] = array(
                            'college_id' => $userId,
                            'title' => $request->alumni_title[$key],
                            'alumni_desc' => $value,
                            'alumni_pic' => $alumniimg,
                            'created_by' => Auth::user()->id,
                            'created_at' => date('Y-m-d h:i:s'),
                        );
                        //endif;
                    endforeach;
                    CollegeAlumni::insert($alumni);

                     endif;
                    return back()->with('success', 'Successfully Added !!');
                }
            }
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    public function addCollGallery() {

        $currentPath = Route::getFacadeRoot()->current()->uri();
        $explodePath = explode('/', $currentPath);
        if (!in_array($explodePath[1], $this->userPermission)) {
            return view('admin.not-allow');
        }
        $college = Helper::getCollege();
        return view('admin.collage.gallery', compact('college'));
    }

    public function addCollScolar() {
        $currentPath = Route::getFacadeRoot()->current()->uri();
        $explodePath = explode('/', $currentPath);
        if (!in_array($explodePath[1], $this->userPermission)) {
            return view('admin.not-allow');
        }
        $college = Helper::getCollege();
        return view('admin.collage.scolarship', compact('college'));
    }

    /*

     * Save collage's gallery
     * @return \Illuminate\Http\Response
     *   
     */

    public function saveGallery(Request $request) {
        try {
            $this->validate($request, [
                'college_id' => 'required',
            ]);

            $images = array();
            if ($files = $request->file('gallery_img')) {
                $i = 1;
                foreach ($files as $file) {
                    $name = time() . $i . '.' . $file->getClientOriginalName();
                    $destinationPath = public_path('/image/gallery/');
                    $file->move($destinationPath, $name);
                    $images[] = $name;
                    $i++;
                }
                $galllist = array();
                foreach ($images as $key => $value) :
                    $galllist[] = array(
                        "img" => $value,
                        "college_id" => $request->college_id,
                        "created_by" => Auth::user()->id,
                        "created_at" => date('Y-m-d h:i:s'),
                    );
                endforeach;
                CollegeGallery::insert($galllist);
                return back()->with('success', 'Successfully Added !!');
            }
            /* Insert your data */
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    public function savescholar(Request $request) {
        try {
            $this->validate($request, [
                'college_id' => 'required',
            ]);

            $datalist = array();
            CollegeScolarship::where('college_id', $request->college_id)->delete();
            if ($request->scoller_offer != ''):
                foreach ($request->scoller_offer as $key => $value) :
                    if ($value != ''):
                        $appli = '';
                        if (isset($_FILES['download_appli']['name'][$key]) && $_FILES['download_appli']['name'][$key] != ''):
                                $appliname = time() . '_' . $_FILES['download_appli']['name'][$key];
                                $destinationPath = public_path('/scolarship_appli/') . $appliname;
                                move_uploaded_file($_FILES['download_appli']['tmp_name'][$key], $destinationPath);
                                $appli = $appliname;
                            else:
                                $appli = $request->applidoc[$key];
                            endif;
                        $datalist[] = array(
                            'college_id' => $request->college_id,
                            'scoller_offer' => $value,
                            'eligibility_criteria' => $request->eligibility_criteria[$key],
                            'appli_process' => $request->appli_process[$key],
                            'last_date_to_appli' => date('Y-m-d', strtotime($request->last_date_to_appli[$key])),
                            'download_appli' => $appli,
                            'created_by' => Auth::user()->id,
                            'created_at' => date('Y-m-d h:i:s'),
                        );
                    endif;

                endforeach;
                CollegeScolarship::insert($datalist);

            endif;
            return back()->with('success', 'Successfully Added !!');

            /* Insert your data */
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    public function show($id) {
        $menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
        if ($menupermission['edit'] == 'No') {
            return view('admin.not-allow');
        }
        $user = User::whereId($id)->first();
        $user['college'] = College::where('user_id', $id)->first();
        $user['collegeAlumni'] = CollegeAlumni::where('college_id', $id)->get();
        $user['collegepro'] = CollegeProminent::where('college_id', $id)->get();
        $user['collegefac'] = CollegeFacilities::where('college_id', $id)->get();
        $user['collegechoose'] = CollegeWhyChoose::where('college_id', $id)->get();
        $collageType = Helper::getCollageType();
        $universityType = Helper::getUniversity();
        $facIcons = Helper::getfacultyicons();

        $tte_careers=TTECareer::all();

        return view('admin.collage.edit', compact('facIcons','collageType', 'universityType', 'user','tte_careers'));
    }

    public function showUni($id) {
        $menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
        if ($menupermission['edit'] == 'No') {
            return view('admin.not-allow');
        }
        $user = User::whereId($id)->first();
        $user['college'] = College::where('user_id', $id)->first();
        $user['collegeAlumni'] = CollegeAlumni::where('college_id', $id)->get();
        $user['collegepro'] = CollegeProminent::where('college_id', $id)->get();
        $user['collegefac'] = CollegeFacilities::where('college_id', $id)->get();
        $collageType = Helper::getCollageType();
        $universityType = Helper::getUniversity();


        return view('admin.collage.edituni', compact('collageType', 'universityType', 'user'));
    }

    public function edit(Request $request, $id) {
        ini_set('memory_limit', '-1');
        try {

            if($request->tte_career){
                $tte_career=implode(',',$request->tte_career);
            }else{
                $tte_career='';
            }

            
             $college = College::where('user_id', $id)->first();
            $this->validate($request, [
                'name' => 'required',
                'website' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'slug' => 'required|unique:gpts_college,slug,'.$college->id,
                'mobile_no' => 'numeric|min:10',
                'address' => 'required'
            ]);

            
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->contact = $request->mobile_no;
            $user->save();
            $userId = $id;
            $alumni = array();
            if ($userId) {

                               
                $college->user_id = $userId;
                $college->collage_type = $request->collage_type;
                $college->university_affiliated = $request->university_type;
                $college->user_name = $request->name;
                $college->about = $request->about;
                $college->slug = $request->slug;
                $college->phone_no = $request->mobile_no;
                $college->landline_no = $request->landline_no;
                $college->alternative_no = $request->alternative_no;
                $college->average_package_offer = $request->average_package_offer;
                $college->address = $request->address;
                $college->website = $request->website;
                $college->tte_career = $tte_career;

                // Edit video
                if (isset($_FILES['video_thumb']['name']) && $_FILES['video_thumb']['name'] != ''):
                    $thumb          = $request->file('video_thumb');
                    $imgname        = $userId.'-'.time() . '.' . $thumb->getClientOriginalExtension();
                    $s3             = \Storage::disk('s3');
                    $filePath       = '/college-video/thumb/' . $imgname;
                    $s3->put($filePath, file_get_contents($thumb), 'public');
                    $video_thumb    = $imgname; 
                else:
                    $video_thumb    = $college->thumb;
                endif;
    
                if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''):
                    $edvideo        = $request->file('video');
                    $videoname      = $userId.'-'.time() . '.' . $edvideo->getClientOriginalExtension();
                    $s3             = \Storage::disk('s3');
                    $filePath       = '/college-video/video/' . $videoname;
                    $s3->put($filePath, file_get_contents($edvideo), 'public');
                    $video          = $videoname;                                
                else:
                    $video          = $college->video;
                endif;

                $college->video = $video;
                $college->thumb = $video_thumb;
                if ($request->hasFile('logo')) {
                    $image = $request->file('logo');
                    $name = time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/image/logo/');
                    $image->move($destinationPath, $name);
                    $college->logo = $name;
                }
                if ($request->hasFile('cover_img')) {
                    $image = $request->file('cover_img');
                    $covername = time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/image/coverimg/');
                    $image->move($destinationPath, $covername);
                    $college->cover_logo = $covername;
                }
                // if ($request->hasFile('head_inst_img')) {
                // $image = $request->file('head_inst_img');
                // $headname = time() . '.' . $image->getClientOriginalExtension();
                // $destinationPath = public_path('/image/');
                // $image->move($destinationPath, $headname);
                // $college->head_inst_img = $headname;
                // }
                // $college->head_inst_msg = $request->head_inst_msg;
                $college->infrastructure = $request->infrastructure;
                $college->life_on_capm = $request->life_on_capm;
                $college->learn_exp = $request->learn_exp;
                $college->extra_curr = $request->extra_curr;
                $college->happi_quot = $request->happi_quot;
                $college->alumni_value = $request->alumni_value;
                if ($request->hasFile('ssi_report')) {
                    $image = $request->file('ssi_report');
                    $ssi_reportname = time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/satisfaction-report');
                    $image->move($destinationPath, $ssi_reportname);
                    $college->ssi_report = $ssi_reportname;
                }

                $college->save();

                if ($userId) {
                    
                    if (isset($request->compy_name)):
                    CollegeProminent::where('college_id', $userId)->delete();    
                    $Prominent = array();
                    foreach ($request->compy_name as $key => $value) :
                       $proimg = '';
                            if (isset($_FILES['pro_logo']['name'][$key]) && $_FILES['pro_logo']['name'][$key] != ''):
                               $proimgname = time() . '_' . $_FILES['pro_logo']['name'][$key];
                            $proPath = public_path('/image/recruiters_image/') . $proimgname;
                            move_uploaded_file($_FILES['pro_logo']['tmp_name'][$key], $proPath);
                            $proimg = $proimgname;
                            else:
                                $proimg = $request->pro_img[$key];
                            endif;
                            $Prominent[] = array(
                                'college_id' => $userId,
                                'compy_name' => $value,
                                'logo' => $proimg,
                                'av_salary' => $request->av_salary[$key],
                                'created_by' => Auth::user()->id,
                                'created_at' => date('Y-m-d h:i:s'),
                            );
                       
                    endforeach;
                    CollegeProminent::insert($Prominent);
                    endif;
                    
                    if (isset($request->choose_title)):
                    CollegeWhyChoose::where('college_id', $userId)->delete();    
                    
                  $choose = array();
                    foreach ($request->choose_title as $key => $value) :
                        //if ($value != ''):
                        $choose[] = array(
                            'college_id' => $userId,
                            'text' => $value,
                            'descr' => $request->choose_desc[$key],
                            'created_at' => date('Y-m-d h:i:s'),
                        );
                  
                    endforeach;
                    CollegeWhyChoose::insert($choose);
                    //endif;
                    endif;
                    if(isset($request->icon)):
                    CollegeFacilities::where('college_id', $userId)->delete();
                    // if ($request->fac_name != ''):
                    $fac = array();
                     foreach ($request->icon as $key => $value) :
                        //if ($value != ''):
                        $fac[] = array(
                            'college_id' => $userId,
                            'icon' => $value,
                            'created_by' => Auth::user()->id,
                            'created_at' => date('Y-m-d h:i:s'),
                        );
                        //endif;
                    endforeach;
                    CollegeFacilities::insert($fac);
                    endif;
                    if(isset($request->alumni_desc)):
                    CollegeAlumni::where('college_id', $userId)->delete();
                    //if ($request->alumni_desc != ''):
                    foreach ($request->alumni_desc as $key => $value) :

                       
                            $alumniimg = '';
                            if (isset($_FILES['alumni_pic']['name'][$key]) && $_FILES['alumni_pic']['name'][$key] != ''):
                                $alumniimgname = time() . '_' . $_FILES['alumni_pic']['name'][$key];
                                $destinationPath = public_path('/image/alumni_pic/') . $alumniimgname;
                                move_uploaded_file($_FILES['alumni_pic']['tmp_name'][$key], $destinationPath);
                                $alumniimg = $alumniimgname;
                            else:
                                $alumniimg = $request->alm_img[$key];
                            endif;
                            $alumni[] = array(
                                'college_id' => $userId,
                                'title' => $request->alumni_title[$key],
                                'alumni_desc' => $value,
                                'alumni_pic' => $alumniimg,
                                'created_by' => Auth::user()->id,
                                'created_at' => date('Y-m-d h:i:s'),
                            );
                      
                    endforeach;
                    CollegeAlumni::insert($alumni);
                    endif;
                    return back()->with('success', 'Successfully Updated !!');
                }
            }
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    public function editGallery($id) {

        $menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
        if ($menupermission['edit'] == 'No') {
            return view('admin.not-allow');
        }
        $college_id = $id;
        $gallery = CollegeGallery::where('college_id', $id)->get();

        $collageType = Helper::getCollageType();
        $universityType = Helper::getUniversity();
        $collegename = User::select('name')->whereId($id)->first();

        return view('admin.collage.editgallery', compact('collegename','collageType', 'universityType', 'gallery', 'college_id'));
    }

    public function delGallery($id) {
        try {
            $menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
            if ($menupermission['delete'] == 'No') {
                return view('admin.not-allow');
            }
            CollegeGallery::where("id", $id)->delete();
            return back()->with('success', 'Successfully Deleted !!');
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return $e->getErrors();
        }
    }

    public function showScholarship($id) {
        $menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
        if ($menupermission['edit'] == 'No') {
            return view('admin.not-allow');
        }
        $college_id = $id;
        $scholarship = CollegeScolarship::where('college_id', $id)->get();

        $collageType = Helper::getCollageType();
        $universityType = Helper::getUniversity();

        $collegename = User::select('name')->whereId($id)->first();
        return view('admin.collage.editscolarship', compact('collegename','collageType', 'universityType', 'scholarship', 'college_id'));
    }

    public function delCollege($id) {
        $menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
        if ($menupermission['delete'] == 'No') {
            return view('admin.not-allow');
        }
        try {
            $model = User::find($id);
            $model->status = 0;
            $model->save();
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return $e->getErrors();
        }
        return redirect('admin/college-list');
    }

    public function delUni($id) {
        $menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
        if ($menupermission['delete'] == 'No') {
            return view('admin.not-allow');
        }
        try {
            $model = User::find($id);
            $model->status = 0;
            $model->save();
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return $e->getErrors();
        }
        return redirect('admin/university-list');
    }
    /**
	 * Update the specified status resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	 
	public function changeStatus(Request $request) {
		$id = $request->id;
		$val = $request->status;
		try {
			$model = User::find($id);
			$model->status = $val;
			$model->save();
			return response()->json($id);
		} catch (\Laracasts\Validation\FormValidationException $e) {
			return $e->getErrors(); 
		}
	}
        

}
