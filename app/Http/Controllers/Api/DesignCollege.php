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
use App\TTECareer;
use Carbon\Carbon;
use App\Setting;
use App\CollegeGallery;
use App\FacilitiesIcon;
use Auth;
use Mail;

class DesignCollege extends Controller {

    use HasApiTokens,
        Notifiable;
    /*
      |--------------------------------------------------------------------------
      | Discover College
      |--------------------------------------------------------------------------
      |
     */
    
    public function design(Request $request) {

        // TTE Clusters
        $query=TTECareer::select('gpts_tte_career_list.tte_career_id','gpts_tte_career_list.name','lib.college_no','lib.under_programme','lib.average_fees','lib.cluster_image','lib.cluster_video','lib.about')->LeftJoin('gpts_career_library as lib','lib.tte_career_id','=','gpts_tte_career_list.tte_career_id');
                $query->whereIn('gpts_tte_career_list.tte_career_id',array('23'));
        $clusters=$query->get();
        
        $datalist = array();
        foreach($clusters as $row){
          $item1['tte_career_id']=$row->tte_career_id;
          $item1['name']=$row->name;
          $item1['about']=$row->about;
          $item1['college_no']=$row->college_no;
          $item1['under_programme']=$row->under_programme;
          $item1['average_fees']=$row->average_fees;
          $item1['cluster_image']=(!empty($row->cluster_image))?"https://s3.eu-west-1.amazonaws.com/gpts-portal/career/discover/" . $row->cluster_image:'';
          $item1['cluster_video']=(!empty($row->cluster_video))?"https://s3.eu-west-1.amazonaws.com/gpts-portal/career/discover/" . $row->cluster_video:'';
          
          $datalist[] = $item1;
        }

        // Cluster Colleges List
        $query = College::select('user_name','video','thumb','location');
        $query->whereRaw('FIND_IN_SET(23,tte_career)');
        $collegelist = $query->get();
        
        $datalist1 = array();
        foreach($collegelist as $row){
          $item['user_name']=$row->user_name;
          $item['location']=$row->location;
          $item['video']=(!empty($row->video))?"https://s3.eu-west-1.amazonaws.com/gpts-portal/college-video/video/" . $row->video:'';
          $item['thumb']=(!empty($row->thumb))?"https://s3.eu-west-1.amazonaws.com/gpts-portal/college-video/thumb/" . $row->thumb:'';
          
          $datalist1[] = $item;
        }
        
        return json_encode(array('msg' => 'Successfully Fetch the data', 'code' => '200','data'=>@$datalist,'collegeslist'=>$datalist1),JSON_PRETTY_PRINT);
    }
    
}
