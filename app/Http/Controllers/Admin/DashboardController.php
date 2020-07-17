<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Helpers\Helper;
use DB;
use Auth;
use App\Order;
use App\Product;
use App\Student;
use App\TteUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use View;
class DashboardController extends Controller
{
	use AuthenticatesUsers;
	private $userRole;
	private $userPermission;
	public function __construct(){
			View::composers([
			'App\Composers\DefaultComposer' => ['admin.layouts.header', 'admin.layouts.footer', 'emails.header']
			]);
			$this->middleware(function ($request, $next) {
				$this->userRole = Auth::user()->usertype;
				$this->userPermission = Helper::getPermission($this->userRole, Auth::user()->created_by);
				$menu = Helper::menu($this->userRole, Auth::user()->created_by);
				view()->composer('admin.layouts.header', function($view) use($menu)
				{
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
    public function index()
    {
		$totalStudent 		= 	User::whereUsertype(1)->count();
		$currentStudent 	= 	User::whereUsertype(1)->limit(8)->orderBy('id', 'DESC')->get();
		
		$totalSchool 		= 	User::whereUsertype(4)->count();

		$tteResult	 		=   User::select('users.*');
								$tteResult->Join('tte_users', 'tte_users.student_id', '=', 'users.id');
								$tteResult->where('users.status',1);
								$tteResult->orderBy('id','DESC');
		$tteResult   		=  	$tteResult->get();

		$result	 			=   User::Join('tte_users', 'tte_users.student_id', '=', 'users.id');
								$result->orderBy('name','ASC');

		$totalTTEStudent	= 	$result->count();
        return view('admin.dashboard', compact('totalStudent', 'totalTTEStudent', 'totalSchool', 'currentStudent', 'tteResult'));
    }

    public function homevideos(Request $request){

    	$videos = DB::table('gpts_home_videos')->select('id','name')->get();

    	return view('admin.homevideos',compact('videos'));
    }

    public function addhomevideos(Request $request,$id=null){

    	error_reporting(0);

    	if($request->method() == 'POST'){
    		$video_id=$request->input('video_id');

    		if($video_id){
    				$video=DB::table('gpts_home_videos')->select('thumbnail','video','poster')->where('id', $video_id)->get();

    				if (isset($_FILES['poster']['name']) && $_FILES['poster']['name'] != ''):
		                $careericon = $request->file('poster');
		                $imgname = uniqid() . '.' . $careericon->getClientOriginalExtension();
		                $s3 = \Storage::disk('s3');
		                $filePath = '/home-video/new/' . $imgname;
		                $s3->put($filePath, file_get_contents($careericon), 'public');
		                $poster = $imgname; 
		            else:
		                $poster = $video[0]->poster;
		            endif;

		            if (isset($_FILES['thumbnail']['name']) && $_FILES['thumbnail']['name'] != ''):
		                $careericon = $request->file('thumbnail');
		                $imgname = uniqid() . '.' . $careericon->getClientOriginalExtension();
		                $s3 = \Storage::disk('s3');
		                $filePath = '/home-video/new/' . $imgname;
		                $s3->put($filePath, file_get_contents($careericon), 'public');
		                $thumbnail = $imgname; 
		            else:
		                $thumbnail = $video[0]->thumbnail;
		            endif;
		            
		            if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''):
		                $expvideo = $request->file('video');
		                $expvideoname = uniqid() . '.' . $expvideo->getClientOriginalExtension();
		                $s3 = \Storage::disk('s3');
		                $filePath = '/home-video/new/' . $expvideoname;
		                $s3->put($filePath, file_get_contents($expvideo), 'public');
		                $video = $expvideoname;                                
		            else:
		                $video = $video[0]->video;
		            endif;

		            if($request->bgvideo==1){
		            	DB::table('gpts_home_videos')
				            ->update(['isbg' =>0]);	
		            }

		            DB::table('gpts_home_videos')
				            ->where('id', $video_id)
				            ->update(['name' => $request->name,'thumbnail'=>$thumbnail,'video'=>$video,'poster'=>$poster,'isbg'=>$request->bgvideo]);

				    return back()->with('success', 'Successfully Updated !!');

    		}else{
	    		if (isset($_FILES['poster']['name']) && $_FILES['poster']['name'] != ''):
	                $careericon = $request->file('poster');
	                $imgname = uniqid() . '.' . $careericon->getClientOriginalExtension();
	                $s3 = \Storage::disk('s3');
	                $filePath = '/home-video/new/' . $imgname;
	                $s3->put($filePath, file_get_contents($careericon), 'public');
	                $poster = $imgname; 
	            else:
	                $poster = '';
	            endif;

	            if (isset($_FILES['thumbnail']['name']) && $_FILES['thumbnail']['name'] != ''):
	                $careericon = $request->file('thumbnail');
	                $imgname = uniqid() . '.' . $careericon->getClientOriginalExtension();
	                $s3 = \Storage::disk('s3');
	                $filePath = '/home-video/new/' . $imgname;
	                $s3->put($filePath, file_get_contents($careericon), 'public');
	                $thumbnail = $imgname; 
	            else:
	                $thumbnail = '';
	            endif;
	            
	            if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''):
	                $expvideo = $request->file('video');
	                $expvideoname = uniqid() . '.' . $expvideo->getClientOriginalExtension();
	                $s3 = \Storage::disk('s3');
	                $filePath = '/home-video/new/' . $expvideoname;
	                $s3->put($filePath, file_get_contents($expvideo), 'public');
	                $video = $expvideoname;                                
	            else:
	                $video = '';
	            endif;

	            if($request->bgvideo==1){
	            	DB::table('gpts_home_videos')
			            ->update(['isbg' =>0]);	
	            }

	            DB::table('gpts_home_videos')->insert([
	            	'name' => $request->name,
	            	'thumbnail' => $thumbnail,
	            	'video'=>$video,
	            	'poster'=>$poster,
	            	'isbg'=>$request->bgvideo
	            ]);

	            return back()->with('success', 'Successfully Added !!');
        	}
    	}else{

    		if($id){
    			$video=DB::table('gpts_home_videos')->select('id','name','thumbnail','video','poster','isbg')->where('id', $id)->get();
    		}

    		return view('admin.addhomevideos',compact('video'));
    	}
    }

    public function deletehomeVideos(Request $request,$video_id){
    	$video=DB::table('gpts_home_videos')->select('thumbnail','video','poster')->where('id', $video_id)->get();
    	
    	\Storage::disk('s3')->delete('/home-video/new/' . $video[0]->thumbnail);
    	\Storage::disk('s3')->delete('/home-video/new/' . $video[0]->video);
    	\Storage::disk('s3')->delete('/home-video/new/' . $video[0]->poster);

    	DB::table('gpts_home_videos')->where('id', '=', $video_id)->delete();

    	return back()->with('success', 'Deleted Successfully !!');
    }

    public function courses(Request $request){
    	error_reporting(0);
    	
    	$courses = DB::table('univ_course_type')->select('univ_course_type.id','univ_course_type.name','univ_stream.name AS stream_name')
    				->join('univ_stream', 'univ_stream.id', '=', 'univ_course_type.stream_id')
    				->get();

    	return view('admin.courses',compact('courses'));	
    }

    public function addCourse(Request $request,$id=null){
    	error_reporting(0);

    	if($request->method() == 'POST'){

    		if($request->input('course_id')){
    			
    			DB::table('univ_course_type')
		            ->where('id', $request->input('course_id'))
		            ->update(['stream_id' => $request->stream,'name' => $request->name]);

				return back()->with('success', 'Successfully Updated !!');
    		}else{
    			DB::table('univ_course_type')->insert([
	            	'stream_id' => $request->stream,
	            	'name' => $request->name
	        	]);
    		}
    		
	        return back()->with('success', 'Successfully Added !!');

    	}else{
    		if($id){
    			$course = DB::table('univ_course_type')->select('id','stream_id','name')->where('id',$id)->get();	
    		}

    		$stream = DB::table('univ_stream')->select('id','name')->get();
    		return view('admin.add_course',compact('stream','course'));
    	}
    }
}
