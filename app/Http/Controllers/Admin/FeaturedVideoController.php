<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\FeaturedVideo;
use App\Helpers\Helper;
use URL;
use Auth;
use Hash;
use Mail;
use Config;
use View;
use Excel;

class FeaturedVideoController extends Controller {

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
        $result = FeaturedVideo::sortable();
        $result->whereIn('status', [0, 1]);
        $result->where(function($query) use ($searchKey) {
            $query->where('name', 'LIKE', '%' . $searchKey . '%');
        });
        $result->orderBy('created_at', 'ASC');
        $videolist = $result->paginate(20);

        return view('admin.featuredvideo.index', compact('videolist'));
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

        return view('admin.featuredvideo.add');
    }

    /*

     * Save school
     * @return \Illuminate\Http\Response
     *   
     */

    public function save(Request $request) {
        try {
            $this->validate($request, [
                'name' => 'required',
                'video_link' => 'required',
            ]);

            $video = new FeaturedVideo;
            $video->name = $request->name;
            $video->title = $request->title;
            $video->location = $request->location;
//            $video->episode = $request->episode;
            $thumb = '';
            if ($request->hasFile('video_thumb')) {
                $image = $request->file('video_thumb');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = public_path('/thumbnail_images');
                $image->move($imagePath, $name);
                $thumb = $name;
            }
            $video->thumb = $thumb;
            $video->video_link = $request->video_link;
            $video->created_by = Auth::user()->id;
            $video->created_at = date('Y-m-d h:i:s');
            $video->save();
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
        $fe_video = FeaturedVideo::find($id);
        return view('admin.featuredvideo.edit', compact('fe_video'));
    }

    /*

     * Update school
     * @return \Illuminate\Http\Response
     *   
     */

    public function edit(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'video_link' => 'required',
        ]);

        try {
            $video = FeaturedVideo::find($id);
            $video->name = $request->name;
            $video->title = $request->title;
            $video->location = $request->location;
//            $video->episode = $request->episode;
            $thumb = '';
            if ($request->hasFile('video_thumb')) {
                $image = $request->file('video_thumb');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = public_path('/thumbnail_images');
                $image->move($imagePath, $name);
                $thumb = $name;
            } else {
                $thumb = $video->thumb;
            }
            $video->thumb = $thumb;
            $video->video_link = $request->video_link;
            $video->created_by = Auth::user()->id;
            $video->created_at = date('Y-m-d h:i:s');
            $video->save();
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
            FeaturedVideo::find($id)->delete();
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
            $model = FeaturedVideo::find($id);
            $model->status = $val;
            $model->save();
            return response()->json($id);
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return $e->getErrors();
        }
    }

}
