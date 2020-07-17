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
use App\College;
use App\Career;
use App\TTECareer;
use Carbon\Carbon;
use App\Setting;
use App\CollegeGallery;
use App\FacilitiesIcon;
use Auth;
use Mail;

class DiscoverColleges extends Controller {

    use HasApiTokens,
        Notifiable;
    /*
      |--------------------------------------------------------------------------
      | Discover College
      |--------------------------------------------------------------------------
      |
     */
    
    public function discover(Request $request) {
        
        // Random Colleges
        /*$query = College::select('gpts_college.user_name','gpts_college.location','gpts_college.video','gpts_college.thumb')->Join('users as user', 'user.id', '=', 'gpts_college.user_id');
                $query->where('user.usertype', 2);
                $query->where('user.status','!=', 0);                
        $random = $query->get()->random(1);
        
        $list = array();
        foreach($random as $row){
          $item['user_name']=$row->user_name;
          $item['location']=$row->location;
          $item['video']=(!empty($row->video))?"https://d33umu47ssmut9.cloudfront.net/career/discover/" . $row->video:'';
          $item['thumb']=(!empty($row->video))?"https://d33umu47ssmut9.cloudfront.net/career/discover/" . $row->thumb:'';
          
          $datalist[] = $item;
        }
		*/
        // TTE Clusters
        $query=TTECareer::select('gpts_tte_career_list.tte_career_id','gpts_tte_career_list.name','lib.cluster_image','lib.cluster_video','lib.video_thumb')->LeftJoin('gpts_career_library as lib','lib.tte_career_id','=','gpts_tte_career_list.tte_career_id');
                $query->whereIn('gpts_tte_career_list.id',array('18','20','14','11','5','10','23','16','8'));
        $clusters=$query->get();
        
        $list1 = array();
        foreach($clusters as $row){
          $item1['tte_career_id']=$row->tte_career_id;
          $item1['name']=$row->name;
          $item1['cluster_image']=(!empty($row->video_thumb))?"https://d33umu47ssmut9.cloudfront.net/career/career-video/" . $row->video_thumb:'';
          $item1['cluster_video']=(!empty($row->cluster_video))?"https://d33umu47ssmut9.cloudfront.net/career/discover/" . $row->cluster_video:'';
          
          $datalist1[] = $item1;
        }
        
        return json_encode(array('msg' => 'Successfully Fetch the data', 'code' => '200', 'random' => @$datalist,'clusters'=>@$datalist1),JSON_PRETTY_PRINT);
    }
    
    public function getCluster(Request $request){
      
      if($request->tte_career_id){
        
        // Cluster Details
        $query=TTECareer::select('gpts_tte_career_list.tte_career_id','gpts_tte_career_list.name','lib.cluster_video','lib.video_thumb','lib.college_no','lib.under_programme','lib.students_enrolled','lib.average_fees','lib.quotes','lib.person_name')->Join('gpts_career_library as lib','lib.tte_career_id','=','gpts_tte_career_list.tte_career_id');
        $query->where('gpts_tte_career_list.tte_career_id',$request->tte_career_id);
        $cluster=$query->get();
        
        $list1 = array();
        foreach($cluster as $row){
          $item1['tte_career_id']=$row->tte_career_id;
          $item1['name']=$row->name;
          $item1['college_no']=$row->college_no;
          $item1['under_programme']=$row->under_programme;
          $item1['students_enrolled']=$row->students_enrolled;
          $item1['average_fees']=$row->average_fees;
          $item1['quotes']=$row->quotes;
          $item1['person_name']=$row->person_name;
          $item1['video_thumb']=(!empty($row->video_thumb))?"https://d33umu47ssmut9.cloudfront.net/career/career-video/" . $row->video_thumb:'';
          $item1['cluster_video']=(!empty($row->cluster_video))?"https://d33umu47ssmut9.cloudfront.net/career/discover/" . $row->cluster_video:'';
          
          $datalist1[] = $item1;
        }

        // Cluster Colleges List
        $query = College::select('user_name','video','thumb');
        $query->whereRaw('FIND_IN_SET('.$request->tte_career_id.',tte_career)');
        $query->skip(0);
        $query->take(4);
        $collegelist = $query->get();
        
        $list = array();
        foreach($collegelist as $row){
          $item['user_name']=$row->user_name;
          $item['video']=(!empty($row->video))?"https://d33umu47ssmut9.cloudfront.net/college-video/video/" . $row->video:'';
          $item['thumb']=(!empty($row->thumb))?"https://d33umu47ssmut9.cloudfront.net/college-video/thumb/" . $row->thumb:'';
          
          $datalist[] = $item;
        }
        
        return json_encode(array('msg' => 'Successfully Fetch the data', 'code' => '200', 'cluster' => @$datalist1,'collegelist'=>@$datalist),JSON_PRETTY_PRINT);
      }
    }
}
