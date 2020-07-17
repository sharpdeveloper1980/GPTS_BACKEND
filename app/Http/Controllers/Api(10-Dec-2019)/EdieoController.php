<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
Use Redirect;
use Illuminate\Http\Request;
use App\User;
use App\Career;
use App\CareerLibaryVideo;
use Carbon\Carbon;
use App\Edieo;
use App\EdieoFav;
use App\MyFav;
use App\Helpers\Helper;
use Auth;
use Mail;
use Config;
use URL;

class EdieoController extends Controller {

    use HasApiTokens,
        Notifiable;

    // Get Edieo for frontend
    public function getEdieo() {

        $list = Edieo::whereStatus(1)->orderBy('position', 'ASC')->get();
       	$allData = array();

       	foreach($list as $key){
       		$data['thumb']			=	"https://d33umu47ssmut9.cloudfront.net/edieo/thumb/".$key->cluster_image;
       		$data['id']				=	$key->id;
       		$data['title']			=	$key->title;
       		if( $key->type == 'must-know' || $key->type == 'must-knowledge'){
       			$allData['mustknow'][] 	=	$data;
       		}else{
       			$allData[$key->type][] 	=	$data;
       		}
       	}
        return response()->json(['code' => '200', 'data' => $allData]);

    }

    // Get Related Edieo
    public function getEdieoOnRequired(Request $request){

    		
    		if($request->type == 'career'){
    			$ftype		= [$request->type];
    			$stype		=	'college';
    		}else if($request->type == 'college'){
    			$ftype		= [$request->type];
    			$stype		= 'career';
    		}else if($request->type == 'mustknow'){
    			$stype		= 'college';
    			$ftype		= ['must-know', 'career'];
    		}else{
    			$ftype		= [$request->type];
    		}

    		//echo 'jhjhjzk';die();
			$edieo 			= Edieo::whereId($request->id)->first();
    		$career         = $edieo->career;

    		if($request->type == 'career' || $request->type == 'college' || $request->type == 'mustknow'){

    			//echo '<pre>';print_r($edieo);die();
				$tabFirst	 	= Edieo::whereCareer($career)->whereStatus(1)->whereIn('type',$ftype)->whereNotIn('id',[$request->id])->get();
    			$tabSecond 		= Edieo::whereCareer($career)->whereStatus(1)->whereType($stype)->get();

    		}else{

				$tabFirst	 	= Edieo::whereIn('type',$ftype)->whereNotIn('id',[$request->id])->get();
    			$tabSecond 		= [];
    		}
    		
    		
    		$arrayAll		= array();

    		// First Tab
    		foreach($tabFirst as $key){
    			$data['id'] 		= $key->id;
    			$data['title'] 		= $key->title;
    			$data['descp'] 		= $key->descp;
    			$data['video_thumb']= "https://d33umu47ssmut9.cloudfront.net/edieo/thumb/".$key->cluster_image;
    			$data['video'] 		= "https://d33umu47ssmut9.cloudfront.net/edieo/video/".$key->video;
    			$data['type'] 		= $key->type;
    			$data['logo'] 		= $key->logo;
    			$arrayAll['firsttab'][]	= $data;
    		}

    		// Second Tab
    		foreach($tabSecond as $key){
    			$data['id'] 		= $key->id;
    			$data['title'] 		= $key->title;
    			$data['descp'] 		= $key->descp;
    			$data['video_thumb']= "https://d33umu47ssmut9.cloudfront.net/edieo/thumb/".$key->cluster_image;
    			$data['video'] 		= "https://d33umu47ssmut9.cloudfront.net/edieo/video/".$key->video;
    			$data['type'] 		= $key->type;
    			$data['logo'] 		= $key->logo;
    			$arrayAll['secondtab'][]	= $data;
    		}

            //echo $career;
            $firstVideo = Career::where('tte_career_id',$career)->whereParent(0)->get();
            $allData=array();
            
            foreach ($firstVideo as $key => $value) :
                    $item['id'] = $value['id'];
                    $item['name'] = $value['name'];
                    $item['slug'] = $value['slug'];
                    $item['edieo_thumb'] = $value['edieo_thumb'] != null ? Config::get('constants.AWSURL').'/career/career-video/' . $value['edieo_thumb'] : '';
                    $item['edieo_cluster_thumb'] = $value['edieo_thumb'] != null ? Config::get('constants.AWSURL').'/career/career-video/' . $value['edieo_cluster_thumb'] : '';
                    $allData[] = $item;               
            endforeach;


            $clusterVideo = Career::whereStatus(1)->whereNotIn('tte_career_id',[$career])->whereParent(0)->get();
            
            foreach ($clusterVideo as $key => $value) :
                    if(!empty($value['edieo_thumb'])){
                        $item['id'] = $value['id'];
                        $item['name'] = $value['name'];
                        $item['slug'] = $value['slug'];
                        $item['edieo_thumb'] = $value['edieo_thumb'] != null ? Config::get('constants.AWSURL').'/career/career-video/' . $value['edieo_thumb'] : '';
                        $item['edieo_cluster_thumb'] = $value['edieo_thumb'] != null ? Config::get('constants.AWSURL').'/career/career-video/' . $value['edieo_cluster_thumb'] : '';
                        $allData[] = $item;   
                    }
                    

            endforeach;

            $arrayAll['clusters'] = $allData;
           // print_r($arrayAll);
            //die();
	        return response()->json(['code' => '200', 'data' => $arrayAll]);


    }

    // Get Single Edieo
    public function getSingleVideo(Request $request){

       // print_r($request->all());die();
        if($request->type == 'cluster'){
            $cluster = Career::whereId($request->id)->first();

            $data['id']         = $cluster->id;
            $data['title']      = $cluster->name;
            $data['descp']      = substr($cluster->about,0,200).'....';
            $data['video_thumb']= $cluster->video_thumb!=''?Config::get('constants.AWSURL')."/career/career-video/" . $cluster->video_thumb:'';
            $data['video']      = $cluster->exp_video!=''?Config::get('constants.AWSURL')."/career/career-video/" . $cluster->exp_video:'';
            //$data['type']       = $cluster->type;
            //$data['logo']       = $cluster->logo;
            $data['created_at'] = date('d M, Y', strtotime($cluster->created_at));
            $arrayAll[] = $data;
        }else if($request->type == 'collegecluster'){
            $cluster = Career::whereId($request->id)->first();

            $data['id']         = $cluster->id;
            $data['title']      = $cluster->name;
            $data['descp']      = substr($cluster->about,0,200).'....';
            $data['video_thumb']= $cluster->cluster_image!=''?Config::get('constants.AWSURL')."/career/career-video/" . $cluster->cluster_image:'';
            $data['video']      = $cluster->cluster_video!=''?Config::get('constants.AWSURL')."/career/career-video/" . $cluster->cluster_video:'';
            //$data['type']       = $cluster->type;
            //$data['logo']       = $cluster->logo;
            $data['created_at'] = date('d M, Y', strtotime($cluster->created_at));
            $arrayAll[] = $data;
        }else{
            $edieo = Edieo::whereId($request->id)->first();
            $data['id']         = $edieo->id;
            $data['title']      = $edieo->title;
            $data['descp']      = $edieo->descp;
            $data['video_thumb']= "https://d33umu47ssmut9.cloudfront.net/edieo/thumb/".$edieo->video_thumb;
            $data['video']      = "https://d33umu47ssmut9.cloudfront.net/edieo/video/".$edieo->video;
            $data['type']       = $edieo->type;
            $data['logo']       = $edieo->logo;
            $data['created_at'] = date('d M, Y', strtotime($edieo->created_at));
            $arrayAll[] = $data;
        }
    	    
	    return response()->json(['code' => '200', 'data' => $arrayAll]);

    }


    // Get Single Edieo
    public function getBannerVideo(Request $request){

    	$edieo = Edieo::wherePriorityVideo(1)->get()->random(1)->first();
		$data['id'] 		= $edieo->id;
		$data['title'] 		= $edieo->title;
		$data['descp'] 		= $edieo->descp;
		$data['video_thumb']= "https://d33umu47ssmut9.cloudfront.net/edieo/thumb/".$edieo->banner_thumb;
		$data['video'] 		= "https://d33umu47ssmut9.cloudfront.net/edieo/video/".$edieo->banner_video;
		$data['type'] 		= ($edieo->type == 'must-know')?'mustknow':$edieo->type;
		$data['logo'] 		= $edieo->logo;
		$arrayAll[]	= $data;	    
	    return response()->json(['code' => '200', 'data' => $arrayAll]);

    }

    // My Fav
    // {'id' => 1, 'user_id' => 1}
   public function favVideo(Request $request){

        if($request->type == 'cluster'){
            $count = MyFav::whereCareerVideo($request->id)->whereUserId($request->user_id)->count();

            if($count > 0){
                return response()->json(['code' => '200', 'msg' => 'Already added to favorite.']);
            }else{
                MyFav::insert(['career_video'=>$request->id, 'user_id'=>$request->user_id, 'created_at' => date('Y-m-d')]);
                return response()->json(['code' => '200', 'msg' => 'Video added to favorite.']);

            }
        }else{
            $count = EdieoFav::whereVideo($request->id)->whereUserId($request->user_id)->count();

            if($count > 0){
                return response()->json(['code' => '200', 'msg' => 'Already added to favorite.']);
            }else{
                EdieoFav::insert(['video'=>$request->id, 'user_id'=>$request->user_id, 'created_at' => date('Y-m-d')]);
                return response()->json(['code' => '200', 'msg' => 'Video added to favorite.']);

            }
        }
    	

   }


}
