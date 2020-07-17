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
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Hash;
use Mail;
use Config;
use URL;
use View;
use Image;
use App\Helpers\Helper;

class CategoryController extends Controller {
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
    public function index(Request $request) {
          $currentPath = Route::getFacadeRoot()->current()->uri();
        $explodePath = explode('/', $currentPath);
        if (!in_array($explodePath[1], $this->userPermission)) {
            return view('admin.not-allow');
        }
        try {
            $searchKey = (isset($request->all()['Search'])) ? $request->all()['Search'] : '';

            $category = Category::sortable()
                    
                    ->where('name', 'LIKE', '%' . $searchKey . '%')
                    ->paginate(10);
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
//        return response()->json(['category'=>$category]);
        return view('admin.category.index', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {


        try {

            $this->validate($request, [
                'name' => 'required|unique:gpts_category|max:255',
                'img' => 'mimes:jpeg,bmp,png',
            ]);
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }

        $category = new Category;
        $category->name = $request->name;

        $category->slug = $request->slug;
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imgname = time() . '.' . $image->getClientOriginalExtension();
            $s3 = \Storage::disk('s3');
            $filePath = '/blog/category/' . $imgname;
            $s3->put($filePath, file_get_contents($image), 'public');
            $category->img = $imgname;
//        $this->save();
//        return back()->with('success','Image Upload successfully');
        }else{
            $category->img = '';
        }
           if (isset($_FILES['img']['name']) && $_FILES['img']['name'] != ''):
                $beginner_video_thumb = $request->file('img');
                $expertimageFileName = time() . '.' . $beginner_video_thumb->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = '/blog/thumb/' . $expertimageFileName;
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
                $thumb = '';
           
            endif;
        $category->description = $request->description;
        $category->meta_tag = $request->meta_tag;
        $category->thumb = $thumb;
        $category->meta_description = $request->meta_description;
        $category->meta_h1 = $request->meta_h1;
        $category->created_at = date('Y-m-d h:i:s');
        $category->save();

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
        $category = Category::find($id);
        return view('admin.category.edit')->withCategory($category);
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
                'name' => 'required|max:255|unique:gpts_category,name,' . $id,
            ]);
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }

        $category = Category::find($id);
        $category->name = $request->name;
        $category->slug = $request->slug;
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imgname = time() . '.' . $image->getClientOriginalExtension();
            $s3 = \Storage::disk('s3');
            $filePath = '/blog/category/' . $imgname;
            $s3->put($filePath, file_get_contents($image), 'public');
            $category->img = $imgname;
//        $this->save();
//        return back()->with('success','Image Upload successfully');
        }else{
            $category->img = $category->img;
        }
        if (isset($_FILES['img']['name']) && $_FILES['img']['name'] != ''):
                $beginner_video_thumb = $request->file('img');
                $expertimageFileName = time() . '.' . $beginner_video_thumb->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                \Storage::disk('s3')->delete('/blog/thumb/' . $category->thumb);
                $filePath = '/blog/thumb/' . $expertimageFileName;
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
                $thumb = $category->thumb;
           
            endif;
        $category->thumb = $thumb; 
        $category->description = $request->description;
        $category->meta_tag = $request->meta_tag;
        $category->meta_description = $request->meta_description;
        $category->meta_h1 = $request->meta_h1;
        $category->save();

        return back()->with('success', 'You have just updated one item');
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
            $category = Category::find($id);
            \Storage::disk('s3')->delete('/blog/category/' . $category->image);
            \Storage::disk('s3')->delete('/blog/thumb/' . $category->thumb);
            Category::find($id)->delete();
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return $e->getErrors();
        }


        return redirect('admin/category');
    }

    /**
     * Remove the image resource from storage.
     *
     * @param  int  $img,$id
     * @return \Illuminate\Http\Response
     */
    public function delImg($img, $id) {
        try {
            $category = Category::find($id);
            \Storage::disk('s3')->delete('/blog/category/' . $category->image);
            \Storage::disk('s3')->delete('/blog/thumb/' . $category->thumb);
            $category->img = '';
            $category->thumb = '';
            $category->save();
          //  $imagePath = public_path('/postimage/') . $img;
          //  unlink($imagePath);
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return $e->getErrors();
        }

        return back()->with('success', 'You have just deleted image successfully!!');
    }

}
