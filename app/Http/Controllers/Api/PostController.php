<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Category;
use App\RelatedPost;
use App\PostComment;
use App\User;
use App\Setting;
use DB;
use PHPMailer\PHPMailer;
use Mail;
use Config;

class PostController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        try {
            $page = $request->input('page');
            $post = Post::where('status',1)->orderByDesc('publish_date')->skip($page*18)->take(18)->get();
            $postCount = Post::where('status',1)->orderByDesc('position')->count();
            $postlist =array();
            foreach ($post as $key => $value) {
                $item['id'] = $value['id'];
                $item['title'] = $value['title'];
                $item['slug'] = $value['slug'];
                $item['description'] = substr($value['short_desc'],0,95);
                $item['author_name'] = $value['author_name'];
                $item['created_at'] = date('d F Y',strtotime($value['publish_date']));
                $item['thumb'] = $value->thumb!=''?Config::get('constants.AWSURL')."/blog/thumb/" . $value->thumb:'https://via.placeholder.com/250x200';
                $postlist[] = $item;
            }

            $arr1 = [];
            $arr2 = [];
            $arr3 = [];
            foreach ($post as $k => $val) {
                if($k >= 0){
                    if (in_array($k - 1, $arr1)){
                        $arr2[] = $k;
                    }elseif(in_array($k - 1, $arr2)){
                        $arr3[] = $k;
                    }elseif(in_array($k - 1, $arr3)){
                        $arr1[] = $k;
                    }else{
                        $arr1[] = $k;
                    }
                }
            }

            $arr_bl = [];
            $bl = $postCount/18;
            if($bl){
                for ($x = 0; $x < $bl; $x++) {
                    $arr_bl[] = $x+1;
                }
            }

        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
       return response()->json(['code' => '200', 'data' => $postlist, 'blogCount' =>$postCount, 'arr1' => $arr1, 'arr2' => $arr2, 'arr3' => $arr3, 'arr_bl' => $arr_bl]);
       }
       
    
     public function getLatestPost($pageno,$limit) {
        try {
            if ($pageno == 'undefined'):
                $page = 1;
            else:
                $page = $pageno;
            endif;
          
            $offset = abs(($page - 1) * $limit);

            
			$post = Post::where(['status' => 0])
						->skip($offset)->take($limit)
						->orderByDesc('id')
						->get();
												
			$totalPost = Post::where(['status' => 0])->count();
			foreach ($post as $index => $eachRow):
				$eachRow['category'] = Category::where(['id' => $eachRow['category']])->first();
				$post[$index] = $eachRow;
			endforeach;			
			$len=round($totalPost/$limit);
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
        return response()->json(['post' => $post, 'totalPost' => $totalPost, 'limit' => $limit, 'page' => $page,'len'=>$len]);
    }

    /**
     * Display a post list as per category.
     *
     * @return \Illuminate\Http\Response
     */
    function getPostByCategory($limit) {
        try {

            $catpost = Post::select("gpts_category.name as catname","gpts_category.id as cat_id","gpts_category.slug as cat_slug")->where(['gpts_post.status' => 0])
                    ->join('gpts_category', 'gpts_post.category', '=', 'gpts_category.id')
                            ->orderByDesc('gpts_post.category')->groupBy('gpts_post.category')->take(4)->get();
            foreach ($catpost as $index => $eachRow):
                $eachRow['post'] = $this->getPostAsPerCat($eachRow['cat_id'],$limit);
            
                $catpost[$index] = $eachRow;
            endforeach;
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
        return response()->json(['catpost' => $catpost]);
    }
    function getPostAsPerCat($cat_id,$limit) {
        $post=Post::where(['status' => 0])->where('category',$cat_id)->orderByDesc('created_at')->take($limit)->get();
         foreach ($post as $index => $eachRow):
             $eachRow['thumb'] = $eachRow['thumb'] != '' ? "https://d33umu47ssmut9.cloudfront.net/blog/thumb/" . $eachRow->thumb:'https://via.placeholder.com/300';
                // $eachRow['title']=strlen($eachRow['title']) > 25 ?ucwords(substr($eachRow['title'],0,25))."...":ucwords($eachRow['title']);
                $eachRow['image'] = $eachRow['image'] != '' ? "https://d33umu47ssmut9.cloudfront.net/blog/post/" . $eachRow->image:'https://via.placeholder.com/300';
                $post[$index] = $eachRow;
            endforeach;
            return $post;
    }

    /**
     * Display single post.
     * @param postSlug string
     * @return \Illuminate\Http\Response
     */
    public function getSinglePost(Request $request) {
        try {

            $singlepost = Post::select('gpts_post.*', 'users.name as author','gpts_category.slug as catslug')
					->join('gpts_category', 'gpts_post.category', '=', 'gpts_category.id')
                    ->Leftjoin('users', 'gpts_post.author', '=', 'users.id')
                    ->where(['gpts_post.status' => 1])
                    ->where('gpts_post.slug', $request->slug)
                    ->first();
            $singlepost['created'] = date('F d, Y',strtotime($singlepost['publish_date']));
            $singlepost['banner_image'] = isset($singlepost['image']) && $singlepost['image']!=''? "https://d33umu47ssmut9.cloudfront.net/blog/post/" . $singlepost->image:'https://via.placeholder.com/750x280';
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
        return response()->json(['code' => '200','singlepost' => $singlepost]);
    }
    public function getLatestPostAsPerPost($postSlug){
             try {
                  $lpost = Post::select('gpts_post.*', 'gpts_category.name as cat_name', 'gpts_category.slug as cat_slug')
                    ->join('gpts_category', 'gpts_post.category', '=', 'gpts_category.id')
                    ->where(['gpts_post.status' => 0])
                    ->where('gpts_post.slug','!=', $postSlug)
                    ->take(3)
                    ->get();
                   foreach ($lpost as $index => $eachRow):
                       // $eachRow['title']=strlen($eachRow['title']) > 35 ?ucwords(substr($eachRow['title'],0,35))."...":ucwords($eachRow['title']);
                $eachRow['image'] = $eachRow['image'] != '' ? url('/') . "/postimage/" . $eachRow['image'] : url('/') . "/postimage/" . '1200px-Mount_Wilhelm.jpg';
               
                $lpost[$index] = $eachRow;
            endforeach;
             } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
return response()->json(['lpost' => $lpost]);
    }

    /**
     * Display all category.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getCategory() {
        try {

            $category = Category::where(['status' => 0])
                            ->orderByDesc('id')->get();
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
        return response()->json(['category' => $category]);
    }

    /**
     * Display all post via category.
     * @param $categorySlug string
     * @param $pageno integer
     * @return \Illuminate\Http\Response
     */
    public function getCatPost($categorySlug, $pageno) {
        try {

            if ($pageno == 'undefined'):
                $page = 1;
            else:
                $page = $pageno;
            endif;
            $limit = 6;
            $offset = abs(($page - 1) * $limit);
            $postlist = Post::select('gpts_post.*', 'users.name as author', 'gpts_category.name as categoryname')
                    ->join('users', 'gpts_post.author', '=', 'users.id')
                    ->join('gpts_category', 'gpts_post.category', '=', 'gpts_category.id')
                    ->where(['gpts_post.status' => 0])
                    ->where('gpts_category.slug', $categorySlug)
                    ->skip($offset)->take($limit)
                    ->orderByDesc('gpts_post.created_at')
                    ->get();
             $totalPost = Post::select(DB::raw("COUNT(gpts_post.id) as totalpost"))
                     ->join('gpts_category', 'gpts_post.category', '=', 'gpts_category.id')
                     ->where('gpts_category.slug', $categorySlug)
                      ->where(['gpts_post.status' => 0])
                     ->first();
            $catname = Category::where(['status' => 0])->where('slug', $categorySlug)->first();
            foreach ($postlist as $index => $eachRow):
                // $eachRow['title']=strlen($eachRow['title']) > 35 ?ucwords(substr($eachRow['title'],0,35))."...":ucwords($eachRow['title']);
                $eachRow['description']= strlen($eachRow['description']) > 250 ?substr($eachRow['description'],0,250)."...":$eachRow['description'];
                $eachRow['image'] = $eachRow['image'] != '' ? url('/') . "/postimage/" . $eachRow['image'] : url('/') . "/postimage/" . '1200px-Mount_Wilhelm.jpg';
                $eachRow['comment'] = $this->getPostCommentcount($eachRow['id']);
                $postlist[$index] = $eachRow;
            endforeach;
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
        return response()->json(['postlist' => $postlist, 'catname' => $catname,'totalpost'=>$totalPost, 'limit' => $limit, 'page' => $page]);
    }

    function getPostCommentcount($post_id) {

        try {
            $postComment = PostComment::select(DB::raw("COUNT(post_id) as totalcomment"))
                    ->where('post_id', $post_id)->where('status', 0)->groupBy("post_id")
                    ->first();
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return $e->getErrors();
        }
        if ($postComment['totalcomment'] != ''):
            return $postComment['totalcomment'];
        else:
            return 0;
        endif;
    }
    function PostComment($post_id) {

        try {
            $postComment = PostComment::
                    where('post_id', $post_id)->where('status', 0)
                    ->skip(0)->take(5)
                    ->orderByDesc('created_at')
                    ->get();
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return $e->getErrors();
        }
        return $postComment;
    }
    function addPostComment(Request $request) {

$postname=Post::select('title','slug')->where('id',$request->post_id)->first();
       $data = array(
					'postname'=> $postname['title'],
					'postSlug'=> $postname['slug'],	
					'msg'=> $request->comment,
					'username'=> $request->name,
					'useremail'=> $request->email,
					'userwebsite'=> $request->website,
					 );
		$setting = Setting::first();
		$userName = $request->name;
		$siteEmail = $setting->robot_email;
		$adminEmail = $setting->admin_email;
    	Mail::send('email.postrequestmail', $data, function($message) use($adminEmail, $siteEmail){
				 $message->to($adminEmail, 'Admin')->subject('Comment from user in blog');
				 $message->from($siteEmail,'gptstube Admin');
				});	
         $PostComment = new PostComment;
        $PostComment->post_id = $request->post_id;
        $PostComment->name = $request->name;
        $PostComment->email = $request->email;
        $PostComment->website = $request->website;
        $PostComment->comment = $request->comment;
      $PostComment->status = 1;
        $PostComment->created_at = date('Y-m-d h:i:s');
        if($PostComment->save()):

            return response()->json(['succ' => true,'msg'=>'Thank you for your comment']);
            else:
            return response()->json(['succ' => false,'msg'=>'please try again']);
        endif;
        
    }
    public function getAuthorName($author_id) {
      $user = User::select('name')->whereId($author_id)->first();
      return $user->name;
    }
    public function getPopularBlog() {
       try {

            $post = Post::where('status',1)->orderByDesc('publish_date')->take(4)->get();
            $postlist =array();
            foreach ($post as $key => $value) {
                $item['id'] = $value['id'];
                $item['title'] = $value['title'];
                $item['slug'] = $value['slug'];
//                $item['author_name'] = $this->getAuthorName($value['author']);
                $item['author_name'] = $value['author_name'];
                $item['description'] = substr(strip_tags($value['description']),0,100);
                $item['created_at'] = date('d F Y',strtotime($value['publish_date']));
                $item['thumb'] = $value->thumb!=''?Config::get('constants.AWSURL')."/blog/thumb/" . $value->thumb:'https://via.placeholder.com/250x200';
                $postlist[] = $item;
            }

            $arr1 = [];
            $arr2 = [];
            $arr3 = [];
            foreach ($post as $k => $val) {
                if($k >= 0){
                    if (in_array($k - 1, $arr1)){
                        $arr2[] = $k;
                    }elseif(in_array($k - 1, $arr2)){
                        $arr3[] = $k;
                    }elseif(in_array($k - 1, $arr3)){
                        $arr1[] = $k;
                    }else{
                        $arr1[] = $k;
                    }
                }
            }

            // echo "<pre>";
            // print_r($arr1);
            // echo "<pre>";
            // print_r($arr2);
            // echo "<pre>";
            // print_r($arr3);
            // echo "<pre>";
            // print_r($postlist);
            // die;

        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
       return response()->json(['code' => '200', 'data' => $postlist, 'arr1' => $arr1, 'arr2' => $arr2, 'arr3' => $arr3]);
    }

    
    public function getLatestBlog() {
       try {

            $post = Post::where('status',1)->orderByDesc('publish_date')->take(2)->get();
            $postlist =array();
            foreach ($post as $key => $value) {
                $item['id'] = $value['id'];
                $item['title'] = $value['title'];
                $item['slug'] = $value['slug'];
//                $item['author_name'] = $this->getAuthorName($value['author']);
                $item['author_name'] = $value['author_name'];
                $item['description'] = substr(strip_tags($value['description']),0,100);
                $item['created_at'] = date('d F Y',strtotime($value['publish_date']));
                $item['thumb'] = $value->thumb!=''?Config::get('constants.AWSURL')."/blog/thumb/" . $value->thumb:'https://via.placeholder.com/250x200';
                $postlist[] = $item;
            }

        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
       return response()->json(['code' => '200', 'data' => $postlist]);
    }

}
