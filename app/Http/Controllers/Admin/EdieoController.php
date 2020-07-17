<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Validation\Rule;
use App\Setting;
use App\Provider;
use App\Helpers\Helper;
use Dirape\Token\Token;
use App\UserType;
use App\Edieo;
use App\TTECareer;
use Auth;
use Hash;
use Mail;
use Config;
use URL;
use View;
use Image;

class EdieoController extends Controller {

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
     * Get Edieo list.
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
        $query = Edieo::sortable();
        $query->where('title', 'LIKE', '%' . $searchKey . '%');
        //$query->where(['status' => 1]);
        $edieo = $query->orderBy('title', 'Desc')->paginate(20);
        return view('admin.edieo.index', compact('edieo'));
    }

    /**
     * Add new Edieo video in  database storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add() {

        $menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
        if ($menupermission['add'] == 'No') {
            return view('admin.not-allow');
        }
        
        $tte_careers=TTECareer::all();
            
        $sub_career=\DB::select("SELECT slug FROM gpts_career_library WHERE type=2");
        
        return view('admin.edieo.add',['tte_careers' => $tte_careers,'sub_career'=>$sub_career]);
    }

    /*
     * save inspiring Videos
     *     
     */
    public function store(Request $request) {
        ini_set('memory_limit', '-1');
        try {

            $this->validate($request, [
                'title'         => 'required',
                'descp'         => 'required',
                'video_thumb'   => 'required|mimes:jpeg,jpg,png,gif',
                'video'         => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm',
            ]);

            if (isset($_FILES['logo']['name']) && $_FILES['logo']['name'] != ''):
                $logoimage      = $request->file('logo');
                $imgname        = time() . '.' . $logoimage->getClientOriginalExtension();
                $s3             = \Storage::disk('s3');
                $filePath       = '/edieo/logo/' . $imgname;
                $s3->put($filePath, file_get_contents($logoimage), 'public');
                $logo           = $imgname; 
            else:
                $logo           = '';
            endif;

            if (isset($_FILES['video_thumb']['name']) && $_FILES['video_thumb']['name'] != ''):
                $thumb     = $request->file('video_thumb');
                $imgname        = time() . '.' . $thumb->getClientOriginalExtension();
                $s3             = \Storage::disk('s3');
                $filePath       = '/edieo/thumb/' . $imgname;
                $s3->put($filePath, file_get_contents($thumb), 'public');
                $video_thumb    = $imgname; 
            else:
                $video_thumb    = '';
            endif;

             if (isset($_FILES['cluster_image']['name']) && $_FILES['cluster_image']['name'] != ''):
                $thumb     = $request->file('cluster_image');
                $imgname        = time() . '.' . $thumb->getClientOriginalExtension();
                $s3             = \Storage::disk('s3');
                $filePath       = '/edieo/thumb/' . $imgname;
                $s3->put($filePath, file_get_contents($thumb), 'public');
                $cluster_image    = $imgname; 
            else:
                $cluster_image    = '';
            endif;

            if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''):
                $edvideo       = $request->file('video');
                $videoname   = time() . '.' . $edvideo->getClientOriginalExtension();
                $s3             = \Storage::disk('s3');
                $filePath       = '/edieo/video/' . $videoname;
                $s3->put($filePath, file_get_contents($edvideo), 'public');
                $video          = $videoname;                                
            else:
                $video          = '';
            endif;

            if (isset($_FILES['banner_video']['name']) && $_FILES['banner_video']['name'] != ''):
                $thumb          = $request->file('banner_video');
                $imgname        = 'bannervideo'.time() . '.' . $thumb->getClientOriginalExtension();
                $s3             = \Storage::disk('s3');
                $filePath       = '/edieo/video/' . $imgname;
                $s3->put($filePath, file_get_contents($thumb), 'public');
                $banner_video    = $imgname; 
            else:
                $banner_video    = '';
            endif;

            $query                  = new Edieo();
            $query->title           = $request->title;
            $query->slug            = $request->sub_career;
            $query->type            = $request->type;   
            $query->descp           = $request->descp;
            $query->career          = $request->career;
            $query->logo            = $logo;
            $query->video_thumb     = $video_thumb;
            $query->cluster_image   = $cluster_image;
            $query->banner_video    = $banner_video;
            $query->position        = $request->position;
            $query->priority_video  = ($request->priority_video == 'on')?1:0;
            $query->video           = $video;
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
        $tte_careers=TTECareer::all();
        $edieo = Edieo::find($id);

        $sub_career=\DB::select("SELECT slug FROM gpts_career_library WHERE type=2");

        return view('admin.edieo.edit',['edieo'=>$edieo,'tte_careers' => $tte_careers,'sub_career'=>$sub_career]);
    }
    
    /**
     * Update the specified edieo video.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {
        ini_set('memory_limit', '-1');

        //echo $request->cluster_image;die();
        try {

            $this->validate($request, [
                'title' => 'required',
                'descp' => 'required',
            ]);
            $query              = Edieo::find($id);
            if (isset($_FILES['logo']['name']) && $_FILES['logo']['name'] != ''):
                $logoimage      = $request->file('logo');
                $imgname        = time() . '.' . $logoimage->getClientOriginalExtension();
                $s3             = \Storage::disk('s3');
                $filePath       = '/edieo/logo/' . $imgname;
                $s3->put($filePath, file_get_contents($logoimage), 'public');
                $logo           = $imgname; 
            else:
                $logo           = $query->logo;
            endif;

            if (isset($_FILES['video_thumb']['name']) && $_FILES['video_thumb']['name'] != ''):
                $thumb     = $request->file('video_thumb');
                $imgname        = time() . '.' . $thumb->getClientOriginalExtension();
                $s3             = \Storage::disk('s3');
                $filePath       = '/edieo/thumb/' . $imgname;
                $s3->put($filePath, file_get_contents($thumb), 'public');
                $video_thumb    = $imgname; 
            else:
                $video_thumb    = $query->video_thumb;
            endif;

            if (isset($_FILES['cluster_image']['name']) && $_FILES['cluster_image']['name'] != ''):
                $thumb     = $request->file('cluster_image');
                $imgname        = time() . '.' . $thumb->getClientOriginalExtension();
                $s3             = \Storage::disk('s3');
                $filePath       = '/edieo/thumb/' . $imgname;
                $s3->put($filePath, file_get_contents($thumb), 'public');
                $cluster_image    = $imgname; 
            else:
                $cluster_image    = $query->cluster_image;
            endif;

            if (isset($_FILES['banner_video']['name']) && $_FILES['banner_video']['name'] != ''):
                $thumb          = $request->file('banner_video');
                $imgname        = 'bannervideo'.time() . '.' . $thumb->getClientOriginalExtension();
                $s3             = \Storage::disk('s3');
                $filePath       = '/edieo/video/' . $imgname;
                $s3->put($filePath, file_get_contents($thumb), 'public');
                $banner_video    = $imgname; 
            else:
                $banner_video    = $query->banner_video;
            endif;


            if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''):
                $edvideo       = $request->file('video');
                $videoname   = time() . '.' . $edvideo->getClientOriginalExtension();
                $s3             = \Storage::disk('s3');
                $filePath       = '/edieo/video/' . $videoname;
                $s3->put($filePath, file_get_contents($edvideo), 'public');
                $video          = $videoname;                                
            else:
                $video          = $query->video;
            endif;

            $query->title       = $request->title;
            $query->slug        = $request->sub_career;
            $query->type        = $request->type;   
            $query->descp       = $request->descp;
            $query->logo        = $logo;
            $query->career      = $request->career;
            $query->video_thumb = $video_thumb;
            $query->position    = $request->position;
            $query->cluster_image = $cluster_image;
            $query->banner_video = $banner_video;
            $query->priority_video  = ($request->priority_video == 'on')?1:0;
            $query->video       = $video;
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
    public function destroy($id) {
        try {
            
            $menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
        if ($menupermission['delete'] == 'No') {
            return view('admin.not-allow');
        }
            $edieo = Edieo::find($id);
            \Storage::disk('s3')->delete('/edieo/logo/' . $edieo->logo);
            \Storage::disk('s3')->delete('/edieo/thumb/' . $edieo->thumb);
            \Storage::disk('s3')->delete('/edieo/video/' . $edieo->video);
            $edieo->find($id)->delete();

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
            $model = Edieo::find($id);
            $model->status = $val;
            $model->save();
            return response()->json($id);
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return $e->getErrors();
        }
    }


    // Video priorty change
    public function changeVideoPriority($id){

        Edieo::where('id', '>', 0)->update(['priority_video' => 0]);
        Edieo::where('id', $id)->update(['priority_video' => 1]);
    }
    
}
