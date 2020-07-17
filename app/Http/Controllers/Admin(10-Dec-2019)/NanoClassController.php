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
use App\NanoClass;
use App\College;
use Auth;
use Hash;
use Mail;
use Config;
use URL;
use View;
use Image;

class NanoClassController extends Controller {

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
     * Get Nano Class list.
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $searchKey      = (isset($request->all()['Search'])) ? $request->all()['Search'] : '';
        $college        = College::where('user_id', $request->id)->first();
        $collegeName    = ucwords($college->user_name);
        $college        =  $request->id;
        $query          = NanoClass::sortable();
        $query->where('title', 'LIKE', '%' . $searchKey . '%');
        $query->where(['college_id' => $request->id]);
        $nanoclass      = $query->orderBy('title', 'Desc')->paginate(20);
        return view('admin.nanoclass.index', compact('nanoclass', 'collegeName', 'college'));

    }

    /**
     * Add Nano Class video in  database storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add($cid) {

        $college        = College::where('user_id', $cid)->first();
        $collegeName    = ucwords($college->user_name);
        return view('admin.nanoclass.add', compact('collegeName', 'cid'));

    }

    /*
     * save inspiring Videos
     *     
     */
    public function store(Request $request) {
        try {

            $this->validate($request, [
                'title'         => 'required',
                'descp'         => 'required',
                'video_thumb'   => 'required|mimes:jpeg,jpg,png,gif',
                'video'         => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm',
            ]);

            if (isset($_FILES['video_thumb']['name']) && $_FILES['video_thumb']['name'] != ''):
                $thumb     = $request->file('video_thumb');
                $imgname        = $request->college.'-'.time() . '.' . $thumb->getClientOriginalExtension();
                $s3             = \Storage::disk('s3');
                $filePath       = '/nanoclass/thumb/' . $imgname;
                $s3->put($filePath, file_get_contents($thumb), 'public');
                $video_thumb    = $imgname; 
            else:
                $video_thumb    = '';
            endif;

            if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''):
                $edvideo        = $request->file('video');
                $videoname      = $request->college.'-'.time() . '.' . $edvideo->getClientOriginalExtension();
                $s3             = \Storage::disk('s3');
                $filePath       = '/nanoclass/video/' . $videoname;
                $s3->put($filePath, file_get_contents($edvideo), 'public');
                $video          = $videoname;                                
            else:
                $video          = '';
            endif;

            $query              =   new NanoClass;
            $query->title       =   $request->title;
            $query->descp       =   $request->descp;
            $query->video_thumb =   $video_thumb;
            $query->video       =   $video;
            $query->college_id  =   $request->college;
            $query->save();
            return back()->with('success', 'Successfully Added !!');
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    public function show($id) {
        $nanoclass      = NanoClass::find($id);
        $college        = College::where('user_id', $nanoclass->college_id)->first();
        $collegeName    = ucwords($college->user_name);
        return view('admin.nanoclass.edit', compact('nanoclass', 'collegeName'));
    }
/**
     * Update the specified edieo video.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {

        try {

            $this->validate($request, [
                'title' => 'required',
                'descp' => 'required',
            ]);
            $query              = NanoClass::find($id);
            
            if (isset($_FILES['video_thumb']['name']) && $_FILES['video_thumb']['name'] != ''):
                $thumb          = $request->file('video_thumb');
                $imgname        = $query->college_id.'-'.time() . '.' . $thumb->getClientOriginalExtension();
                $s3             = \Storage::disk('s3');
                $filePath       = '/nanoclass/thumb/' . $imgname;
                $s3->put($filePath, file_get_contents($thumb), 'public');
                $video_thumb    = $imgname; 
            else:
                $video_thumb    = $query->video_thumb;
            endif;

            if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''):
                $edvideo        = $request->file('video');
                $videoname      = $query->college_id.'-'.time() . '.' . $edvideo->getClientOriginalExtension();
                $s3             = \Storage::disk('s3');
                $filePath       = '/nanoclass/video/' . $videoname;
                $s3->put($filePath, file_get_contents($edvideo), 'public');
                $video          = $videoname;                                
            else:
                $video          = $query->video;
            endif;

            $query->title       = $request->title;
            $query->descp       = $request->descp;
            $query->video_thumb = $video_thumb;
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
            $nanoclass = NanoClass::find($id);
            \Storage::disk('s3')->delete('/nanoclass/thumb/' . $nanoclass->thumb);
            \Storage::disk('s3')->delete('/nanoclass/video/' . $nanoclass->video);
            $nanoclass->find($id)->delete();

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
            $model = NanoClass::find($id);
            $model->status = $val;
            $model->save();
            return response()->json($id);
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return $e->getErrors();
        }
    }
    
}
