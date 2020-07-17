<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Validation\Rule;
use App\User;
use App\Post;
use App\Category;
use DB;
use App\RelatedPost;
use App\PostComment;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Hash;
use Mail;
use Config;
use URL;
use View;
use Image;
use App\Helpers\Helper;

class PostController extends Controller {

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

            $post = Post::select("gpts_post.*", "gpts_category.name as cat_name", "gpts_category.id as cat_id")->sortable()
                    ->where('gpts_post.title', 'LIKE', '%' . $searchKey . '%')
                    ->join('gpts_category', 'gpts_post.category', '=', 'gpts_category.id')
                    ->orderByDesc('gpts_post.id')
                    ->paginate(10);
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
        return view('admin.post.index', compact('post'));
    }

    /**

     * Display the form.
     *
     * @return \Illuminate\Http\Response
     */
    public function add() {
         $currentPath = Route::getFacadeRoot()->current()->uri();
        $explodePath = explode('/', $currentPath);
        if (!in_array($explodePath[1], $this->userPermission)) {
            return view('admin.not-allow');
        }
        try {

            $res['category'] = Category::orderByDesc('name')->get();
            $list['category'] = array("" => "select");
            foreach ($res['category'] as $row):
                $list['category'][$row['id']] = $row['name'];
            endforeach;
            $res['postlist'] = Post::orderByDesc('title')->get();
            foreach ($res['postlist'] as $row):
                $list['postlist'][$row['id']] = $row['title'];
            endforeach;
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
        return view('admin.post.add', compact('list'));
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
                'title' => 'required',
                'category' => 'required',
                'image' => 'mimes:jpeg,bmp,png',
                'slug' => 'required|unique:gpts_post,slug'
            ]);
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }

        $post = new post;
        $category = Category::where('id', $request->category)->first();
        $post->title = $request->title;
        if ($request->hasFile('image')) {
            $postimage = $request->file('image');
            $imgname = time() . '.' . $postimage->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = '/blog/post/' . $imgname;
                $s3->put($filePath, file_get_contents($postimage), 'public');
                $post->image = $imgname;
        }  else {
            $post->image = '';
        }
        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != ''):
                $beginner_video_thumb = $request->file('image');
                $expertimageFileName = time() . '.' . $beginner_video_thumb->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = '/blog/thumb/' . $expertimageFileName;
                $destinationPath = public_path('/thumbnail_images');
                 $thumb_img = Image::make($beginner_video_thumb->getRealPath());
                 $thumb_img->resize(250, null, function ($constraint) {
                 $constraint->aspectRatio();
                });
                $thumb_img->save($destinationPath.'/'.$expertimageFileName);

                $s3->put($filePath, file_get_contents($destinationPath.'/'.$expertimageFileName), 'public');
                unlink($destinationPath.'/'.$expertimageFileName);
                $thumb = $expertimageFileName;
            else:
                $thumb = '';
           
            endif;
        $post->description = $request->description;
        $post->slug = $request->slug;
        $post->meta_h1 = $request->meta_h1;
        $post->meta_tag = $request->meta_tag;
        $post->meta_description = $request->meta_description;
        $post->short_desc = $request->short_desc;
        $post->author_name = $request->author_name;
        $post->position = $request->position;
        $post->publish_date = date('Y-m-d', strtotime($request->publish_date));
        $post->thumb = $thumb;
        $post->author = auth()->user()->id;
        $post->category = $request->category;
        if(Auth::user()->usertype==11 || Auth::user()->usertype==12):
                    $post->status = 1;
                else:
                    $post->status=0;
                endif;
        $post->created_at = date('Y-m-d h:i:s');
        $post->save();
        if ($request->related_post != ''):
            $list = array();
            foreach ($request->related_post as $key => $eachRelatedPost):
                $data = [
                    "post_id" => $post->id,
                    "related_post_id" => $eachRelatedPost,
                    "created_at" => date('Y-m-d h:i:s')
                ];
                array_push($list, $data);
            endforeach;

            RelatedPost::insert($list);

        endif;
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
        try {

            $res['category'] = Category::orderByDesc('name')->get();
            $list['category'] = array("" => "select");
            foreach ($res['category'] as $row):
                $list['category'][$row['id']] = $row['name'];
            endforeach;
            $res['postlist'] = Post::where('id', '!=', $id)->orderByDesc('title')->get();
            foreach ($res['postlist'] as $row):
                $list['postlist'][$row['id']] = $row['title'];
            endforeach;
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
        $post = Post::find($id);
        $relatedPost = RelatedPost::where('post_id', $id)->get();
        $relatedpostlist = array();
        foreach ($relatedPost as $value):
            $relatedpostlist[] = $value['related_post_id'];
        endforeach;
        return view('admin.post.edit', compact('list', 'post', 'relatedpostlist'));
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
                'title' => 'required',
                'category' => 'required',
                'image' => 'mimes:jpeg,bmp,png',
                'slug' => 'required|unique:gpts_post,slug,'. $id,
            ]);
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
        $post = Post::find($id);
        $post->title = $request->title;
        if ($request->hasFile('image')) {
             $postimage = $request->file('image');
              $imgname = time() . '.' . $postimage->getClientOriginalExtension();
              \Storage::disk('s3')->delete('/blog/post/' . $post->image);
                $s3 = \Storage::disk('s3');
                $filePath = '/blog/post/' . $imgname;
                $s3->put($filePath, file_get_contents($postimage), 'public');
                $post->image = $imgname;
        } else {
            $post->image = $post->image;
        }
         if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != ''):
                $beginner_video_thumb = $request->file('image');
                $expertimageFileName = time() . '.' . $beginner_video_thumb->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                \Storage::disk('s3')->delete('/blog/thumb/' . $post->thumb);
                $filePath = '/blog/thumb/' . $expertimageFileName;
                $destinationPath = public_path('/thumbnail_images');
                 $thumb_img = Image::make($beginner_video_thumb->getRealPath());
                 $thumb_img->resize(250, null, function ($constraint) {
                 $constraint->aspectRatio();
                });
                $thumb_img->save($destinationPath.'/'.$expertimageFileName);

                $s3->put($filePath, file_get_contents($destinationPath.'/'.$expertimageFileName), 'public');
                unlink($destinationPath.'/'.$expertimageFileName);
                $thumb = $expertimageFileName;
            else:
                $thumb = $post->thumb;
           
            endif;
        $post->description = $request->description;
        $post->slug = $request->slug;
        $post->meta_h1 = $request->meta_h1;
        $post->meta_tag = $request->meta_tag;
        $post->thumb = $thumb;
        $post->meta_description = $request->meta_description;
        $post->short_desc = $request->short_desc;
        $post->author_name = $request->author_name;
        $post->position = $request->position;
        $post->publish_date = date('Y-m-d', strtotime($request->publish_date));
        $post->author = auth()->user()->id;
        $post->category = $request->category;
        $post->save();
        if ($request->related_post == ''):
            RelatedPost::where('post_id', $id)->delete();
        endif;
        if ($request->related_post != ''):

            RelatedPost::where('post_id', $id)->delete();
            $list = array();
            foreach ($request->related_post as $key => $eachRelatedPost):
                $data = [
                    "post_id" => $id,
                    "related_post_id" => $eachRelatedPost,
                    "created_at" => date('Y-m-d h:i:s')
                ];
                array_push($list, $data);
            endforeach;

            RelatedPost::insert($list);

        endif;
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
            $post = Post::find($id);
            \Storage::disk('s3')->delete('/blog/post/' . $post->image);
            \Storage::disk('s3')->delete('/blog/thumb/' . $post->thumb);
            PostComment::where('post_id', $id)->delete();
            RelatedPost::where('post_id', $id)->delete();
            Post::find($id)->delete();
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return $e->getErrors();
        }


        return redirect('admin/post');
    }

    /**
     * Remove the image resource from storage.
     *
     * @param  int  $img,$id
     * @return \Illuminate\Http\Response
     */
    public function delImg($img, $id) {
        try {

            $post = Post::find($id);
            \Storage::disk('s3')->delete('/blog/post/' . $post->image);
            \Storage::disk('s3')->delete('/blog/thumb/' . $post->thumb);
            $post->image = '';
            $post->thumb = '';
            $post->save();
            // $imagePath = public_path('/postimage/') . $img;
            //  unlink($imagePath);
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return $e->getErrors();
        }

        return back()->with('success', 'You have just deleted image successfully!!');
    }

    /**

     * Display all comment post count.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPostComment() {
        try {
            $postComment = PostComment::select(DB::raw("gpts_post.id as post_id,gpts_post.title,users.name as authorname,gpts_post_comment.created_at ,COUNT(gpts_post_comment.post_id) as totalcomment"))
                            ->join('gpts_post', 'gpts_post_comment.post_id', '=', 'gpts_post.id')
                            ->join('users', 'gpts_post.author', '=', 'users.id')
                            ->orderByDesc('gpts_post_comment.created_at')->groupBy("gpts_post_comment.post_id")->get();
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return $e->getErrors();
        }
        return view('admin.post.comment', compact('postComment'));
    }

    /**

     * Display post comment.
     * @param $post_id number
     * @return \Illuminate\Http\Response
     */
    public function showSinglePostComment($post_id) {
        try {
            $postComment = PostComment::select('gpts_post_comment.*', 'gpts_post.id as post_id', 'gpts_post.title', 'users.name as authorname')
                            ->join('gpts_post', 'gpts_post_comment.post_id', '=', 'gpts_post.id')
                            ->join('users', 'gpts_post.author', '=', 'users.id')
                            ->where('gpts_post_comment.post_id', $post_id)
                            ->orderByDesc('gpts_post_comment.created_at')->get();
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return $e->getErrors();
        }
        return view('admin.post.postcomment', compact('postComment'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editPostComment($id) {
        try {
            $postComment = PostComment::select('gpts_post_comment.*', 'gpts_post.id as post_id', 'gpts_post.title', 'users.name as authorname')
                            ->join('gpts_post', 'gpts_post_comment.post_id', '=', 'gpts_post.id')
                            ->join('users', 'gpts_post.author', '=', 'users.id')
                            ->where('gpts_post_comment.id', $id)
                            ->orderByDesc('gpts_post_comment.id')->first();
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return $e->getErrors();
        }
        return view('admin.post.editcomment', compact('postComment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateComment(Request $request, $id) {
        try {
            $this->validate($request, [
                'comment' => 'required',
                'name' => 'required',
                'email' => 'required'
            ]);
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }

        $PostComment = PostComment::find($id);
        $PostComment->name = $request->name;
        $PostComment->email = $request->email;
        $PostComment->website = $request->website;
        $PostComment->comment = $request->comment;
        $PostComment->created_at = date('Y-m-d h:i:s');
        $PostComment->save();

        return back()->with('success', 'You have just updated one item');
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $postid
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPostComment($postid, $id) {
        try {

            $postcomment = PostComment::find($id)->delete();
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return $e->getErrors();
        }


        return redirect('viewcomment/' . $postid);
    }

    /**
     * Approved post comment.
     * @param  int  $postid
     * @param  int  $id
     * @param  int  $status
     * @return \Illuminate\Http\Response
     */
    public function PostCommentApproved($postid, $id, $status) {
        try {

            $postcomment = PostComment::
                    where('id', $id)
                    ->update(['status' => $status]);
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return $e->getErrors();
        }


        return redirect('viewcomment/' . $postid);
    }

    public function postmeta($catid) {
        try {

            $cat = Category::select('name as catname')
                    ->where(['id' => $catid])
                    ->first();
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
        echo json_encode($cat);
    }

    public function changePostStatus($post_id, $status) {

        $post = Post::
                where('id', $post_id)
                ->update(['status' => $status]);
        echo json_encode(array("succ" => "Status Updated Successfully"));
    }

}
