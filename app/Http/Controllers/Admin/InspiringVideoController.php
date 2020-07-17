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
use App\InspiringVideo;
use App\Provider;
use App\HomeVideo;
use App\Helpers\Helper;
use Dirape\Token\Token;
use Auth;
use Hash;
use Mail;
use Config;
use URL;
use View;
use Image;

class InspiringVideoController extends Controller {

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
        $query = InspiringVideo::sortable();
        $query->where('title', 'LIKE', '%' . $searchKey . '%');
        $inspringvideo = $query->orderBy('title', 'Desc')->paginate(20);
       
        return view('admin.inspiring_video.index', compact('inspringvideo'));
    }
    
    /**
     * Add new inspiring video in  database storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add() {
         $menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
        if ($menupermission['add'] == 'No') {
            return view('admin.not-allow');
        }
       
        return view('admin.inspiring_video.add');
    }
    /*

     * save inspiring Videos
     *     
     */
    public function save(Request $request) {
        try {

            $this->validate($request, [
                'title' => 'required',
                'name' => 'required',
                'video' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm',
                'video_thumb' => 'required|mimes:jpeg,jpg,png,gif',
            ]);
            $query = new InspiringVideo();
            $query->title = $request->title;
            $query->name = $request->name;   
            $query->designation = $request->designation;
            $query->position = $request->position; 
            if (isset($_FILES['video_thumb']['name']) && $_FILES['video_thumb']['name'] != ''):
                $careericon = $request->file('video_thumb');
                $imgname = time() . '.' . $careericon->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = '/inspiring/image/' . $imgname;
                $s3->put($filePath, file_get_contents($careericon), 'public');
                $video_thumb = $imgname; 
            else:
                $video_thumb = '';
            endif;
             $query->video_thumb = $video_thumb;
              if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''):
                $expvideo = $request->file('video');
                $expvideoname = time() . '.' . $expvideo->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = '/inspiring/video/' . $expvideoname;
                $s3->put($filePath, file_get_contents($expvideo), 'public');
                $video = $expvideoname;                                
            else:
                $video = '';
            endif;
             $query->video = $video;
            $query->save();
            return back()->with('success', 'Successfully Added !!');
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    public function show($id) {
        // $menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
        // if ($menupermission['edit'] == 'No') {
        //     return view('admin.not-allow');
        // }

        $inspringvideo = InspiringVideo::find($id);
        return view('admin.inspiring_video.edit', compact('inspringvideo'));
    }

    /**
     * Update the specified career detail in database storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {

        try {

            $this->validate($request, [
                'title' => 'required',
                'name' => 'required',
            ]);

            $query = InspiringVideo::find($id);
            $query->title = $request->title;
            $query->name = $request->name;    
            $query->designation = $request->designation;
            $query->position = $request->position;

            if (isset($_FILES['video_thumb']['name']) && $_FILES['video_thumb']['name'] != ''):
                $careericon = $request->file('video_thumb');
                $imgname = time() . '.' . $careericon->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = '/inspiring/image/' . $imgname;
                $s3->put($filePath, file_get_contents($careericon), 'public');
                $video_thumb = $imgname; 
            else:
                $video_thumb = $query->video_thumb;
            endif;
             $query->video_thumb = $video_thumb;
              if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''):
                $expvideo = $request->file('video');
                $expvideoname = time() . '.' . $expvideo->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = '/inspiring/video/' . $expvideoname;
                $s3->put($filePath, file_get_contents($expvideo), 'public');
                $video = $expvideoname;                                
            else:
                $video = $query->video;
            endif;
             $query->video = $video;
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
            $inspiringVideo = InspiringVideo::find($id);
            \Storage::disk('s3')->delete('/inspiring/image/' . $inspiringVideo->video_thumb);
            \Storage::disk('s3')->delete('/inspiring/video/' . $inspiringVideo->video);
            InspiringVideo::find($id)->delete();
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
            $model = InspiringVideo::find($id);
            $model->status = $val;
            $model->save();
            return response()->json($id);
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return $e->getErrors();
        }
    }
    
     /*

     * Home Video
     * @param int id
    */
   public function SatticPageVideo(Request $request) {
      $currentPath = Route::getFacadeRoot()->current()->uri();
        $explodePath = explode('/', $currentPath);
        if (!in_array($explodePath[1], $this->userPermission)) {
            return view('admin.not-allow');
        }

        $searchKey = (isset($request->all()['Search'])) ? $request->all()['Search'] : '';
        $query = HomeVideo::sortable();
        $query->where('title', 'LIKE', '%' . $searchKey . '%');
        $staticvideo = $query->orderBy('title', 'Desc')->paginate(20);
       
        return view('admin.homeVideo.index', compact('staticvideo'));
   }
    /*

     * Home Video
     * @param int id
    */
   public function editHomeVideo($id,$type) {
       $videolist = HomeVideo::whereId($id)->whereType($type)->first();
       return view('admin.homeVideo.edit', compact('videolist'));
   }
   
  /*

   * Save home video
  */
 public function saveHomeVideo(Request $request,$id) {
       try {

            $this->validate($request, [
                'title' => 'required',
                'name' => 'required',
            ]);

            $query = HomeVideo::find($id);
            $query->title = $request->title;
            $query->name = $request->name;
            //$query->description = $request->description;         
            if (isset($_FILES['video_thumb']['name']) && $_FILES['video_thumb']['name'] != ''):
                $careericon = $request->file('video_thumb');
                $imgname = time() . '.' . $careericon->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = '/home-video/' . $imgname;
                $s3->put($filePath, file_get_contents($careericon), 'public');
                $video_thumb = $imgname; 
            else:
                $video_thumb = $query->video_thumb;
            endif;
             $query->video_thumb = $video_thumb;
              if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''):
                $expvideo = $request->file('video');
                $expvideoname = time() . '.' . $expvideo->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = '/home-video/' . $expvideoname;
                $s3->put($filePath, file_get_contents($expvideo), 'public');
                $video = $expvideoname;                                
            else:
                $video = $query->video;
            endif;
             $query->video = $video;
            $query->save();
            return back()->with('success', 'Successfully Updated !!');
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        } 
 }

   
}
