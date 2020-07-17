<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Category;
use App\OurTeam;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Hash;
use Mail;
use Config;
use URL;
use View;
use Image;
use App\Helpers\Helper;

class OurTeamController extends Controller {

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$type='') {
        $currentPath = Route::getFacadeRoot()->current()->uri();
        $explodePath = explode('/', $currentPath);
        if (!in_array($explodePath[1], $this->userPermission)) {
            return view('admin.not-allow');
        }
        try {
            $searchKey = (isset($request->all()['Search'])) ? $request->all()['Search'] : '';

            $query = OurTeam::sortable()->where('name', 'LIKE', '%' . $searchKey . '%');
            if(isset($type) && $type!='' && $type!=='all'):
             $query = $query->whereType($type);   
            endif;
            $teamlist = $query->paginate(10);
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
//        return response()->json(['category'=>$team]);
        return view('admin.ourteam.index', compact('teamlist'));
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
        $typelist = array(
            "1" => "LEADERSHIP",
            "2" => "TEAM",
        );
        return view('admin.ourteam.add', compact('typelist'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */public function store(Request $request) {


        try {

            $this->validate($request, [
                'name' => 'required',
                'designation' => 'required',
                'description' => 'required|max:200',
                'image' => 'mimes:jpeg,bmp,png',
            ]);
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }

        $team = new OurTeam;
        $team->name = $request->name;
        $team->designation = $request->designation;
        $team->descr = $request->description;
        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != ''):
            $team_thumb = $request->file('image');
            $expertimageFileName = time() . '.' . $team_thumb->getClientOriginalExtension();
            $s3 = \Storage::disk('s3');
            $filePath = '/teamthumb/' . $expertimageFileName;
            $destinationPath = public_path('/thumbnail_images');
            $thumb_img = Image::make($team_thumb->getRealPath());
//            $thumb_img->resize(245, null, function ($constraint) {
//                $constraint->aspectRatio();
//            });
            $thumb_img->save($destinationPath . '/' . $expertimageFileName);

            $s3->put($filePath, file_get_contents($destinationPath . '/' . $expertimageFileName), 'public');
            unlink($destinationPath . '/' . $expertimageFileName);
            $thumb = $expertimageFileName;
        else:
            $thumb = '';

        endif;
        $team->image = $thumb;
        $team->linkedin = $request->linkedin;
        $team->twitter = $request->twitter;
        $team->type = $request->type;
        $team->created_by = Auth::user()->id;
        $team->created_at = date('Y-m-d h:i:s');
        $team->save();

        return back()->with('success', 'You have just created one item');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
          $menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
        if ($menupermission['edit'] == 'No') {
            return view('admin.not-allow');
        }
        $team = OurTeam::find($id);
         $typelist = array(
            "1" => "LEADERSHIP",
            "2" => "TEAM",
        );
        return view('admin.ourteam.edit', compact('team','typelist'));
    }
    
    
    public function edit(Request $request,$id) {
         try {

            $this->validate($request, [
                'name' => 'required',
                'designation' => 'required',
                'description' => 'required|max:200',
                'image' => 'mimes:jpeg,bmp,png',
            ]);
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }

        $team = OurTeam::find($id);
        $team->name = $request->name;
        $team->designation = $request->designation;
        $team->descr = $request->description;
        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != ''):
            $team_thumb = $request->file('image');
            $expertimageFileName = time() . '.' . $team_thumb->getClientOriginalExtension();
            $s3 = \Storage::disk('s3');
            $filePath = '/teamthumb/' . $expertimageFileName;
            $destinationPath = public_path('/thumbnail_images');
            $thumb_img = Image::make($team_thumb->getRealPath());
//            $thumb_img->resize(245, null, function ($constraint) {
//                $constraint->aspectRatio();
//            });
            $thumb_img->save($destinationPath . '/' . $expertimageFileName);

            $s3->put($filePath, file_get_contents($destinationPath . '/' . $expertimageFileName), 'public');
            unlink($destinationPath . '/' . $expertimageFileName);
            $thumb = $expertimageFileName;
        else:
            $thumb = $team->image;

        endif;
        $team->image = $thumb;
        $team->linkedin = $request->linkedin;
        $team->twitter = $request->twitter;
        $team->type = $request->type;
        $team->created_by = Auth::user()->id;
        $team->created_at = date('Y-m-d h:i:s');
        $team->save();
        return back()->with('success', 'Updated Sucessfully');
    }
    
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
          $menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
        if ($menupermission['delete'] == 'No') {
            return view('admin.not-allow');
        }
        try {
            $ourteam = OurTeam::find($id);
            \Storage::disk('s3')->delete('/teamthumb/' . $ourteam->image);
            OurTeam::find($id)->delete();
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return $e->getErrors();
        }


        return redirect('admin/teamlist');
    }

    /**
     * Remove the image resource from storage.
     *
     * @param  int  $img,$id
     * @return \Illuminate\Http\Response
     */
    public function delImg($img, $id) {
        try {
             $ourteam = OurTeam::find($id);
            \Storage::disk('s3')->delete('/teamthumb/' . $ourteam->image);
            $ourteam->image = '';
            $ourteam->save();
          //  $imagePath = public_path('/postimage/') . $img;
          //  unlink($imagePath);
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return $e->getErrors();
        }

        return back()->with('success', 'You have just deleted image successfully!!');
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
            $model = OurTeam::find($id);
            $model->status = $val;
            $model->save();
            return response()->json($id);
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return $e->getErrors();
        }
    }


}
