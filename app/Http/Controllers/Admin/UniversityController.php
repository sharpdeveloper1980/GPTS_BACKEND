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


class UniversityController extends Controller
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
	
    public function index()
    {
		error_reporting(0);
		
		$videos = DB::table('gpts_university')->select('gpts_university.id','gpts_university.name','gpts_career_library.name AS cluster_name')
					->join('gpts_career_library','gpts_career_library.id','=','gpts_university.cluster_id')
					->get();

        return view('admin.university_listing',compact('videos'));
    }

    public function addUniversityVideo(Request $request,$id=null){
    	error_reporting(0);

    	if($request->method() == 'POST'){

    		$video_id=$request->input('video_id');

    		if($video_id){
    			$video=DB::table('gpts_university')->select('thumbnail','video','poster')->where('id', $video_id)->get();
    			
    			if (isset($_FILES['poster']['name']) && $_FILES['poster']['name'] != ''):
	                $careericon = $request->file('poster');
	                $imgname = uniqid() . '.' . $careericon->getClientOriginalExtension();
	                $s3 = \Storage::disk('s3');
	                $filePath = '/university/' . $imgname;
	                $s3->put($filePath, file_get_contents($careericon), 'public');
	                $poster = $imgname; 
	            else:
	                $poster = $video[0]->poster;
	            endif;

	            if (isset($_FILES['thumbnail']['name']) && $_FILES['thumbnail']['name'] != ''):
	                $careericon = $request->file('thumbnail');
	                $imgname = uniqid() . '.' . $careericon->getClientOriginalExtension();
	                $s3 = \Storage::disk('s3');
	                $filePath = '/university/' . $imgname;
	                $s3->put($filePath, file_get_contents($careericon), 'public');
	                $thumbnail = $imgname; 
	            else:
	                $thumbnail = $video[0]->thumbnail;
	            endif;
	            
	            if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''):
	                $expvideo = $request->file('video');
	                $expvideoname = uniqid() . '.' . $expvideo->getClientOriginalExtension();
	                $s3 = \Storage::disk('s3');
	                $filePath = '/university/' . $expvideoname;
	                $s3->put($filePath, file_get_contents($expvideo), 'public');
	                $video = $expvideoname;                                
	            else:
	                $video = $video[0]->video;
	            endif;

	            DB::table('gpts_university')
		            ->where('id', $video_id)
		            ->update(['cluster_id'=>$request->cluster,'name' => $request->name,'thumbnail'=>$thumbnail,'video'=>$video,'poster'=>$poster]);

				return back()->with('success', 'Successfully Updated !!');

    		}else{

    		if (isset($_FILES['poster']['name']) && $_FILES['poster']['name'] != ''):
                $careericon = $request->file('poster');
                $imgname = uniqid() . '.' . $careericon->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = '/university/' . $imgname;
                $s3->put($filePath, file_get_contents($careericon), 'public');
                $poster = $imgname; 
            else:
                $poster = '';
            endif;

            if (isset($_FILES['thumbnail']['name']) && $_FILES['thumbnail']['name'] != ''):
                $careericon = $request->file('thumbnail');
                $imgname = uniqid() . '.' . $careericon->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = '/university/' . $imgname;
                $s3->put($filePath, file_get_contents($careericon), 'public');
                $thumbnail = $imgname; 
            else:
                $thumbnail = '';
            endif;
            
            if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''):
                $expvideo = $request->file('video');
                $expvideoname = uniqid() . '.' . $expvideo->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = '/university/' . $expvideoname;
                $s3->put($filePath, file_get_contents($expvideo), 'public');
                $video = $expvideoname;                                
            else:
                $video = '';
            endif;

			DB::table('gpts_university')->insert([
					'cluster_id'=>$request->cluster,
	            	'name' => $request->name,
	            	'thumbnail' => $thumbnail,
	            	'video'=>$video,
	            	'poster'=>$poster
	        ]);

	        return back()->with('success', 'Successfully Added !!');
	        

    		}
    	}else{
    		$cluster=DB::table('gpts_career_library')->select('id','name')->where(['deleted'=>0,'parent'=>0])->get();

    		if($id){
    			$video=DB::table('gpts_university')->select('id','cluster_id','name','thumbnail','video','poster')->where('id', $id)->get();
    		}

    		return view('admin.add_university',compact('cluster','video'));
    	}
	}

	public function deleteUniversityVideo(Request $request,$id)
	{
		if($id){
			$video=DB::table('gpts_university')->select('thumbnail','video','poster')->where('id', $id)->get();
    		
	    	\Storage::disk('s3')->delete('/university/' . $video[0]->thumbnail);
	    	\Storage::disk('s3')->delete('/university/' . $video[0]->video);
	    	\Storage::disk('s3')->delete('/university/' . $video[0]->poster);

	    	DB::table('gpts_university')->where('id', '=', $id)->delete();

	    	return back()->with('success', 'Deleted Successfully !!');
	    }
	}
  
}
